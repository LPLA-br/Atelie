<?php

namespace Src\Domain\ValueObject;

use Src\Domain\ValueObject\IPreco;

class Preco implements IPreco
{
  private float $preco; //precisão não é crítica

  public function __construct( float $preco )
  {
    $this->validarValorPositivo( $preco );

    $this->preco = $preco;
  }

  public function definirNovoPreco( float $proposta ): void
  {
    $this->validarValorPositivo( $proposta );
    $this->preco = $proposta;
  }

  public function zerarPreco(): void
  {
    $this->preco = 0.0;
  }

  public function multiplicar( int $quantidade ): void
  {
    $this->validarValorPositivo( $quantidade );

    $this->preco = $this->preco * $quantidade;
  }

  public function subtrair( int $subtraendo ): void
  {
    $this->validarValorPositivo( $subtraendo );
    $this->validarSubtraibilidade( $subtraendo );

    $this->preco = $this->preco - $subtraendo;
  }

  public function obterPreco(): float
  {
    return $this->preco;
  }

  protected function validarValorPositivo( float $proposta ): void
  {
    if ( !$this->ePositivo( $proposta ) )
    {
      throw new \Exception( "Não existem preços negativos." );
    }
    return;
  }

  protected function validarSubtraibilidade( float $proposta ): void
  {
    if( !$this->eSubtraivel( $proposta ) )
    {
      throw new \Exception( "Subtração resultará em valor menor que zero." );
    }
    return; 
  }

  protected function ePositivo( float $proposta ): bool
  {
    if ( $proposta < 0.0 )
    {
      return false;
    }
    return true;
  }

  protected function eSubtraivel( $numeroProposto ): bool
  {
    if ( $numeroProposto <= $this->preco )
    {
      return true;
    }
    return false;
  }
}
