<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\AInsumo;

/* Representa N insumos cujo custo computa-se por unidade. */
class InsumoUnitario extends AInsumo
{

  public function __construct( int $id, string $nome, IPreco $preco )
  {
    parent::__construct( $id, $nome, $preco );
  }

  /* int retifica float para inteiro automaticamente. */
  public function aumentarUnidades( int $aumento ): void
  {
    $this->validarUnidades( $aumento );

    try
    {
      $this->preco->aumentarQuantidade( $aumento );
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  public function diminuirUnidades( int $diminuicao ): void
  {
    $this->validarUnidades( $diminuicao );
    $this->validarSubracaoExcessiva( $diminuicao );

    try
    {
      $this->preco->diminuirQuantidade( $diminuicao );
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  public function obterQuantidadeUnidades(): int
  {
    try
    {
      return $this->preco->obterQuantidade();
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  public function obterPrecoUnidade(): float
  {
    try
    {
      return $this->preco->obterPreco();
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  //----------------------------------------------------------------------------

  private function validarUnidades( int $numero ): void
  {
    if ( !$this->ePositivaUnidades( $numero ) )
    {
      throw new \Exception( "Unidades invalidas por valor menor que zero." );
    }
    return;
  }

  private function validarDiminuicaoExcessiva( int $proposta ): void
  {
    if ( !$this->eDiminutivel( $proposta ) )
    {
      throw new \Exception( "Diminuicao de quantidade maior que quantidade disponivel." );
    }
    return;
  }
  
  private function ePositivaUnidades( int $numero ): bool
  {
    if ( $numero >= 0.0 )
    {
      return true;
    }
    return false;
  }

  private function eDiminutivel( int $proposta ): bool
  {
    if ( $proposta > $this->preco->obterQuantidade() )
    {
      return false;
    }
    return true;
  }
}
