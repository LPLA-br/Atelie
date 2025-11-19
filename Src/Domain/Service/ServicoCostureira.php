<?php

namespace Src\Domain\Service;

use Src\Domain\Enum\EServicoTipo;
use Src\Domain\Enum\EServicoEstado;

use Src\Domain\Entity\Peca;
use Src\Domain\Collection\PecasColecao;

class ServicoCostureira
{
  private int $id;

  private EServicoTipo $tipo;
  private EServicoEstado $estado;

  private PecasColecao $pecas;

  public function __construct(  int $id,
    EServicoTipo $tipo,
    EServicoEstado $estado,
    PecasColecao $pecas
  )
  {
    $this->id = $id;

    $this->tipo = $tipo;
    $this->estado = $estado;
    $this->pecas = $pecas;
  }

  // CONTROLE DE ESTADOS INFORMACIONAIS

  public function iniciar(): void
  {
    $this->invalidarAcaoPorEstadoConcluido( "está concluido" );
    $this->invalidarAcaoPorEstadoAbortado( "está abortado !" );
    $this->invalidarAcaoPorEstadoConcluidoParcialmente( "está concluido (parcialmente)" );
    $this->invalidarAcaoPorEstadoProgredinte( "já está progredinte" );
    $this->invalidarAcaoPorEstadoPendente( "está marcado como pendente pós inicio" );

    $this->estado = EServicoEstado::Progredinte;
    return;
  }

  public function continuar(): void
  {
    $this->iniciar();
  }

  public function tornarPedente(): void
  {
    $this->invalidarAcaoPorEstadoConcluido( "" );
    $this->invalidarAcaoPorEstadoAbortado( "" );
    $this->invalidarAcaoPorEstadoConcluidoParcialmente( "" );
    $this->invalidarAcaoPorEstadoPendente( "" );

    $this->estado = EServicoEstado::Pedente;
    return;
  }

  public function concluir(): void
  {
    $this->invalidarAcaoPorEstadoConcluido( "" );
    $this->invalidarAcaoPorEstadoAbortado( "" );
    $this->invalidarAcaoPorEstadoConcluidoParcialmente( "" );
    $this->invalidarAcaoPorEstadoPendente( "" );

    if ( $this->obterQuantidadeDePecasPendentes() > 0 )
    {
      $this->estado = EServicoEstado::Concluido_parcialmente;
      return;
    }

    $this->estado = EServicoEstado::Concluido;
    return;
  }

  public function abortar(): void
  {
    $this->invalidarAcaoPorEstadoConcluido( "" );
    $this->invalidarAcaoPorEstadoAbortado( "" );
    $this->invalidarAcaoPorEstadoConcluidoParcialmente( "" );

    $this->estado = EServicoEstado::Abortado;
    return;
  }

  //TIPO DO SERVIÇO DE DOMÍNIO

  public function definirTipo( EServicoTipo $tipo ): void
  {
    $this->tipo = $tipo;
  }

  public function alterarTipo( EServicoTipo $tipo ): void
  {
    $this->tipo = $tipo;
  }

  //MANIPULAÇÃO DA COLEÇÃO DE PEÇAS (delegação de responsabilidade)

  public function computarCustoTodasPecas(): void
  {
    $this->pecas->computarCusto();
  }

  public function obterQuantidadeDePecasPendentes(): int
  {
    // Coleção de peças
    return 0;
  }

  public function adicionarPeca( IPeca $peca ): void
  {
    $this->pecas->adicionar( $peca );
  }

  public function removerPeca(): void
  {

  }

  //-------------------------------------------------

  private function invalidarAcaoPorEstadoPendente( string $mensagem ): void
  {
    if ( $this->estaPendente() )
    {
      throw new Exception( get_class($this) . ": " . $mensagem );
    }
    return;
  }

  private function invalidarAcaoPorEstadoProgredinte( string $mensagem ): void
  {
    if ( $this->estaProgredinte() )
    {
      throw new Exception( get_class($this) . ": " . $mensagem );
    }
    return;
  }

  private function invalidarAcaoPorEstadoConcluido( string $mensagem ): void
  {
    if ( $this->estaConcluido() )
    {
      throw new Exception( get_class($this) . ": " . $mensagem );
    }
    return;
  }

  private function invalidarAcaoPorEstadoConcluidoParcialmente( string $mensagem ): void
  {
    if ( $this->estaConcluidoParcialmente() )
    {
      throw new Exception( get_class($this) . ": " . $mensagem );
    }
    return;
  }

  private function invalidarAcaoPorEstadoAbortado( string $mensagem ): void
  {
    if ( $this->estaAbortado() )
    {
      throw new Exception( get_class($this) . ": " . $mensagem );
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
