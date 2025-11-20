<?php

namespace Src\Domain\ValueObject;

class Medida
{
  public object $camposDinamicos;

  public function __construct( string $camposDinamicos )
  {
    $this->validarJSONCamposDinamicos( $camposDinamicos );
    $this->camposDinamicos = json_decode( $camposDinamicos );
    $this->validarInteiroFlutuanteEmTodosCampos();
  }

  public function obterTodasMedidas(): object
  {
    return $this->camposDinamicos;
  }

  public function alterarMedida( string $campo, float $novoValor ): void
  {
    if ( $this->camposDinamicos[$campo] === NULL ) throw new Exception( "Campo inexistente." ); 
    $this->camposDinamicos[ $campo ] = $novoValor;
  }

  public function emitirJSON(): string
  {
    return json_encode( $this->camposDinamicos );
  }

  //---------------------------------------------------

  protected function validarJSONCamposDinamicos( string $json ): void
  {
    $objeto = json_decode( $json );
    if ( $objeto === NULL )
    {
      throw new \Exception( "Campos dinâmicos inválidos" );
    }
  }

  protected function validarInteiroFlutuanteEmTodosCampos(): void
  {
    foreach( $this->camposDinamicos as $campo )
    {
      if ( !is_float( $campo ) )
      {
        throw new \Exception( "Campo não float detectado. ABORTADO!" );
      }
    }
  }
}
