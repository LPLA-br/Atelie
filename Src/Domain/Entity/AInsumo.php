<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\ITemObterId;

abstract class AInsumo implements ITemObterId
{
  protected int $id;
  protected string $nome;
  protected IPreco $preco;

  public function __construct( int $id, string $nome, IPreco $preco )
  {
    $this->validarNome( $nome );

    $this->id = $id;
    $this->nome = $nome;
    $this->preco = $preco;
  }

  public function obterId(): int
  {
    return $this->id;
  }

  public function obterNome(): string
  {
    return $this->nome;
  }

  public function obterCusto(): float
  {
    try
    {
      return $this->preco->obterTotal();
    }
    catch ( \Exception $e )
    {
      error_log( $e->getMessage() );
    }
  }

  //----------------------------------------------------------------------------

  protected function validarNome( string $proposta ): void
  {
    if ( !$this->eNome( $proposta ) )
    {
      throw new \Exception( "Insumo sem nome válido." );
    }
    return;
  }

  protected function eNome( string $proposta ): bool
  {
    if ( $proposta == "" )
    {
      return false;
    }
    return true;
  }

}
