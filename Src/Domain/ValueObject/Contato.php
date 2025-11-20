<?php

namespace Src\Domain\ValueObject;

class Contato
{
  private string $telefone;
  private string $email;

  public function __construct( string $telefone, string $email )
  {
    $this->validarTelefone( $telefone );
    $this->validarEmail( $email );

    $this->telefone = $telefone;
    $this->celular = $celular;
  }

  public function getTelefone(): string
  {
    return $this->telefone;
  }
  
  public function getEmail(): string
  {
    return $this->email;
  }

  //---------------------------------------

  protected function validarEmail( string $email ): void
  {
    $padrao = "/.*@[a-z]*.com/";

    if ( !preg_match( $padrao, $email ) )
    {
      throw new \Exception( "Email " . $email . "Invalido" );
    }
  }

  protected function validarTelefone( string $telefone ): void
  {
    $padrao = "/^[0-9]{8,9}/";

    if ( preg_match( $padrao, $telefone ) )
    {
      throw new \Exception( "Telefone " . $telefone . "Invalido" );
    }
  }
}
