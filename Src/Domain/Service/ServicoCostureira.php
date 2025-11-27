<?php

namespace Src\Domain\Service;

use Src\Domain\Enum\EServicoTipo;
use Src\Domain\Enum\EServicoEstado;

use Src\Domain\Entity\Cliente;
use Src\Domain\Entity\Peca;
use Src\Domain\Collection\PecasColecao;

/*Classe matriz do processo do Ateliê */
class ServicoCostureira
{
  private int $id;

  private EServicoTipo $tipo;
  private EServicoEstado $estado;

  private Cliente $cliente;
  private PecasColecao $pecas;

  private EServicoEstado $estadoNovo;

  public function __construct(
    int $id,
    EServicoTipo $tipo,
    EServicoEstado $estado,
    Cliente $cliente,
    PecasColecao $pecas
  )
  {
    $this->id = $id;

    $this->tipo = $tipo;
    $this->estado = $estado;

    $this->cliente = $cliente;
    $this->pecas = $pecas;
  }

  //--------------------------------------
  // CONTROLE DE ESTADOS INFORMACIONAIS

  public function iniciar(): void
  {
    $this->estadoNovo = EServicoEstado::Progredinte;

    $this->invalidarAcaoPorEstadoConcluido();
    $this->invalidarAcaoPorEstadoAbortado();
    $this->invalidarAcaoPorEstadoConcluidoParcialmente();
    $this->invalidarAcaoPorEstadoProgredinte();

    $this->estado = EServicoEstado::Progredinte;
  }

  public function continuar(): void
  {
    $this->iniciar();
  }

  public function pausar(): void
  {
    $this->estadoNovo = EServicoEstado::Pendente;

    $this->invalidarAcaoPorEstadoConcluido();
    $this->invalidarAcaoPorEstadoAbortado();
    $this->invalidarAcaoPorEstadoConcluidoParcialmente();
    $this->invalidarAcaoPorEstadoPendente();

    $this->estado = EServicoEstado::Pendente;
  }

  public function concluir(): void
  {
    $this->estadoNovo = EServicoEstado::Concluido;

    $this->invalidarAcaoPorEstadoConcluido();
    $this->invalidarAcaoPorEstadoAbortado();
    $this->invalidarAcaoPorEstadoConcluidoParcialmente();
    $this->invalidarAcaoPorEstadoPendente();

    if ( $this->obterQuantidadeDePecasPendentes() > 0 )
    {
      $this->estado = EServicoEstado::Concluido_parcialmente;
      return;
    }

    $this->estado = EServicoEstado::Concluido;
  }

  public function abortar(): void
  {
    $this->invalidarAcaoPorEstadoConcluido();
    $this->invalidarAcaoPorEstadoAbortado();
    $this->invalidarAcaoPorEstadoConcluidoParcialmente();

    $this->estado = EServicoEstado::Abortado;
  }

  //--------------------------------------

  public function obterEstado(): EServicoEstado
  {
    return $this->estado;
  }

  public function obterTipo(): EServicoTipo
  {
    return $this->tipo;
  }

  //--------------------------------------
  // SETOR MODIFICATIVO/SEMÂNTICO SERVIÇO

  public function definirTipo( EServicoTipo $tipo ): void
  {
    $this->tipo = $tipo;
  }

  public function alterarTipo( EServicoTipo $tipo ): void
  {
    $this->tipo = $tipo;
  }

  //--------------------------------------
  // SETOR PEÇAS

  public function obterCustoTodasPecas(): float
  {
    return $this->pecas->computarCustoTotal();
  }

  public function obterQuantidadeDePecasPendentes(): int
  {
    return $this->pecas->obterQuantidadePecasPendentes();
  }

  public function obterPecaComMaiorPrazo(): string
  {
    return $this->pecas->obterPrazoDaPecaMaiorPrazo();
  }

  public function adicionarPeca( Peca $peca ): void
  {
    $this->pecas->adicionar( $peca );
  }

  public function removerPecaPorId( int $id ): void
  {
    $this->pecas->removerPorId( $id );
  }

  //-------------------------------------------------
  // SETOR VALIDATÓRIO DE MUDAÇAS DE ESTADO

  private function invalidarAcaoPorEstadoPendente(): void
  {
    if ( $this->estaPendente() )
    {
      throw new \Exception( $this->estadoNovo->value . " não pode ser aplicado em Serviço Pendente." );
    }
    return;
  }

  private function invalidarAcaoPorEstadoProgredinte(): void
  {
    if ( $this->estaProgredinte() )
    {
      throw new \Exception( $this->estadoNovo->value . " não pode ser aplicado em Serviço Progredinte." );
    }
    return;
  }

  private function invalidarAcaoPorEstadoConcluido(): void
  {
    if ( $this->estaConcluido() )
    {
      throw new \Exception( $this->estadoNovo->value . " não pode ser aplicado em Serviço Concluido." );
    }
    return;
  }

  private function invalidarAcaoPorEstadoConcluidoParcialmente(): void
  {
    if ( $this->estaConcluidoParcialmente() )
    {
      throw new \Exception( $this->estadoNovo->value . " não pode ser aplicado em Serviço Concluido Parcialmente." );
    }
    return;
  }

  private function invalidarAcaoPorEstadoAbortado(): void
  {
    if ( $this->estaAbortado() )
    {
      throw new \Exception( $this->estadoNovo->value . " não pode ser aplicado em Serviço Abortado." );
    }
    return;
  }

  //-------------------------------------------------------

  private function estaProgredinte(): bool
  {
    if ( $this->estado === EServicoEstado::Progredinte )
    {
      return true;
    }
    return false;
  }

  private function estaPendente(): bool
  {
    if ( $this->estado === EServicoEstado::Pendente )
    {
      return true;
    }
    return false;
  }

  private function estaConcluido(): bool
  {
    if ( $this->estado === EServicoEstado::Concluido )
    {
      return true;
    }
    return false;
  }

  private function estaConcluidoParcialmente(): bool
  {
    if ( $this->estado === EServicoEstado::Concluido_parcialmente )
    {
      return true;
    }
    return false;
  }

  private function estaAbortado(): bool
  {
    if ( $this->estado === EServicoEstado::Abortado )
    {
      return true;
    }
    return false;
  }

}
