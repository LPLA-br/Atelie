<?php

namespace Src\Domain\ValueObject;

use Src\Domain\ValueObject\IPreco;

/* Representa preço de N objetos. */
class Preco implements IPreco
{
  // PRECISÃO NÃO CRÍTICA 
  private float $preco; //preço associado a unidade abstrata d'algo.
  private float $quantidade; //float -> POG
  private float $total;

  public function __construct( float $preco, float $quantidade )
  {
    $this->validarValorPositivo( $preco );
    $this->validarValorPositivo( $quantidade );
 
    $this->preco = $preco;
    $this->quantidade = $quantidade;

    $this->total = 0.0;
    $this->computarTotal();
  }

  public function alterarPreco( float $proposta ): void
  {
    $this->validarValorPositivo( $proposta );

    $this->preco = $proposta;
    $this->computarTotal();
  }

  public function aumentarQuantidade( float $numero ): void
  {
    $this->validarValorPositivo( $numero );
    $this->quantidade += $numero; 
    $this->computarTotal();
    return;
  }

  public function diminuirQuantidade( float $numero ): void
  {
    $this->validarValorPositivo( $numero );
    $this->validarDiminuicaoQuantidade( $numero );
    $this->quantidade -= $numero;
    $this->computarTotal();
    return;
  }

  public function obterPreco(): float
  {
    return $this->preco;
  }

  public function obterQuantidade(): float
  {
    return $this->quantidade;
  }

  public function obterTotal(): float
  {
    return $this->total;
  }

  //--------------------------------------------------

  protected function computarTotal(): void
  {
    $this->total = $this->preco * $this->quantidade;
  }

  protected function validarValorPositivo( float $proposta ): void
  {
    if ( !( $proposta >= 0 ) )
    {
      throw new \Exception( "Exceção por valor negativo." );
    }
    return;
  }

  protected function validarDiminuicaoQuantidade( float $quantidade ): void
  {
    if ( !$this->eQuantidadeDiminutivel( $quantidade ) )
    {
      throw new \Exception( "Exceção por quantidade inferior a zero." );
    }
    return;
  }

  protected function eQuantidadeDiminutivel( float $quantidade ): bool
  {
    if ( !( ($this->quantidade - $quantidade) >= 0.0 ) )
    {
      return false;
    }
    return true;
  }

}
