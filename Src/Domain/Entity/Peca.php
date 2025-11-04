<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\Prazo;
use Src\Domain\Enum\EPecaEstado;
use Src\Domain\Enum\EPecaTipo;
use Src\Domain\Collection\InsumosColecao;
use Src\Domain\Entity\AInsumo;

class Peca
{
  private int $id;
  private string $descricao;

  private EPecaTipo $tipo;
  private EPecaEstado $estado;

  private Prazo $prazo;
  private InsumosColecao $insumos;

  public function __construct(
    int $id,
    string $descricao, 
    EPecaTipo $tipo,
    EPecaEstado $estado,
    Prazo $prazo,
    InsumosColecao $insumo )
  {
    $this->id = $id;
    $this->descricao = $descricao;

    $this->tipo = $tipo;
    $this->estado = $estado;

    $this->prazo = $prazo;
    $this->insumos = $insumo;
  }

  // MANIPULAÇÃO DE ESTADOS DA PEÇA

  public function iniciarTrabalhoPeca(): void
  {
    $this->invalidarPorConclusao( "Iniciar trabalho em peça concluida." );
    $this->invalidarPorAbortamento( "Iniciar trabalho em peça abortada." );

    $this->estado = EPecaEstado::Progredinte;
    return;
  }

  public function suspenderTrabalhoPeca(): void
  {
    $this->invalidarPorConclusao( "Suspender trabalho em peça concluida." );
    $this->invalidarPorAbortamento( "Suspender trabalho em peça abortada." );

    if ( $this->estaProgredinte() )
    {
      $this->estado = EPecaEstado::Pendente;
      return;
    }
    throw new \Exception( "Apenas peças em progresso podem ser suspensas.");
  }

  public function concluirPeca(): void
  {
    $this->invalidarPorConclusao( "Concluir peça já concluida." );
    $this->invalidarPorAbortamento( "Concluir peça abortada." );

    if ( $this->estaProgredinte() )
    {
      $this->estado = EPecaEstado::Concluida;
      return;
    }
    throw new \Exception( "Apenas peças em progresso podem ser concluídas.");
  }

  /* Requer forte confirmação */
  public function abortarPeca(): void
  {
    $this->invalidarPorConclusao( "Abortar peça já concluida." );
    $this->invalidarPorAbortamento( "Abortar peça já abortada." );

    if ( !$this->estaConcluida() )
    {
      $this->estado = EPecaEstado::Abortada;
      return;
    }
    throw new \Exception( "apenas peças não concluidas podem ser abortadas." );
  }

  // MANIPULAÇÃO DE TIPOLOGIA DA PEÇA

  public function definirTipo( EPecaTipo $tipo ): void
  {
    $this->tipo = $tipo;
  }


  // GETTERS

  public function obterId(): int
  {
    return $this->id;
  }

  public function obterDescricao(): string
  {
    return $this->descricao;
  }

  public function obterTipo(): EPecaTipo
  {
    return $this->tipo;
  }

  public function obterEstado(): EPecaEstado
  {
    return $this->estado;
  }

  public function obterPrazo(): string
  {
    try
    {
      return $this->prazo->obterPrazo();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function obterCustoTodosInsumos(): float
  {
    try
    {
      return $this->insumos->obterSomatorioCustoTodosInsumos();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function obterQuantidadeUnidades(): int
  {
    try
    {
      return $this->obterContagemInsumosUnitarios();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function obterAreaTecido(): float
  {
    try
    {
      return $this->insumos->obterSomatorioAreaInsumosQuadrados();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function obterColecaoInsumos(): array
  {
    try
    {
      return $this->insumos->obterColecao();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function obterQuantidadeTodosInsumos(): int
  {
    try
    {
      return $this->insumos->obterTotalInsumos();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  // TELL. Don't ask
  // MANIPULAÇÃO DA COLEÇÃO DE INSUMOS DA PEÇA

  public function adicionarInsumo( AInsumo $insumo ): void
  {
    try
    {
      $this->insumos->adicionar( $insumo );
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function removerInsumo( int $id ): void
  {
    try
    {
      $this->insumos->removerPorId( $id );
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function substituirInsumo( int $id, AInsumo $substituto ): void
  {
    try
    {
      $this->insumos->substituirPorId( $id, $substituto );
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  // PRAZOS (A peça com o prazo mais distante em uma coleção determina estado temporal do serviço)

  public function definirPrazo( string $data ): void
  {
    try
    {
      $this->prazo->definirPrazo( $data );
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function extenderPrazo( string $data ): void
  {
    try
    {
      $this->prazo->extenderPrazo( $data );
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function indeterminarPrazo(): void
  {
    try
    {
      $this->prazo->indeterminarPrazo();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  public function restaurarPrazo(): void
  {
    try
    {
      $this->prazo->restaurarPrazo();
    }
    catch ( \Exception $e )
    {
      error_log( $e );
    }
  }

  // INVALIDAÇÃO DE AÇÕES SEM SENTIDO NO DOMÍNIO

  protected function invalidarPorConclusao( string $complemento ): void
  {
    if ( $this->estaConcluida() )
    {
      throw new Exception( "Peça concluida." . $complemento );
    }
  }

  protected function invalidarPorAbortamento( string $complemento ): void
  {
    if ( $this->estaAbortada() )
    {
      throw new Exception( "Peça abortada." . $complemento );
    }
  }

  // VERIFICAÇÃO DE ESTADOS SEMÂNTICOS

  protected function estaPendente(): bool
  {
    if ( $this->estado === EPecaEstado::Pendente )
    {
      return true;
    }
    return false;
  }

  protected function estaProgredinte(): bool
  {
    if ( $this->estado === EPecaEstado::Progredinte )
    {
      return true;
    }
    return false;
  }

  protected function estaConcluida(): bool
  {
    if ( $this->estado === EPecaEstado::Concluida )
    {
      return true;
    }
    return false;
  }

  protected function estaAbortada(): bool
  {
    if ( $this->estado === EPecaEstado::Abortada )
    {
      return true;
    }
    return false;
  }
}
