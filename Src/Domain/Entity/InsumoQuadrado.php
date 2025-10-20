<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\AInsumo;

/* Representa N insumos cujo custo computa-se pela unidade espacial Racional
  *bidimensional: o metro quadrado. */
class InsumoQuadrado extends AInsumo
{

  /* Metros quadrados iguais a quantidade flutuante em preço */
  public function __construct( int $id, string $nome, IPreco $preco )
  {
    parent::__construct( $id, $nome, $preco );

    $this->validarAreaQuadrada( $this->preco->obterQuantidade() );
  }

  public function aumentarArea( float $aumento ): void
  {
    try
    {
      $this->preco->aumentarQuantidade( $aumento );
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  public function diminuirArea( float $diminuicao ): void
  {
    try
    {
      $this->preco->diminuirQuantidade( $diminuicao );
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  public function obterMetrosQuadrados(): float
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

  //----------------------------------------------------------------------------

  protected function validarAreaQuadrada( float $proposta ): void
  {
    if ( !$this->ePositivaArea( $proposta ) )
    {
      throw new \Exception( "Metro quadrado invalido por valor menor que zero." );
    }
    return;
  }

  protected function ePositivaArea( float $proposta ): bool
  {
    if ( $proposta > 0 )
    {
      return true;
    }
    return false;
  }
}

