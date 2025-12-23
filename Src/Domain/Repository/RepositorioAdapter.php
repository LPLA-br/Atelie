<?php
// Keep It Simple, Stupid !

namespace Src\Domain\Repository;

use \Src\Domain\Repository\IRepositorio;

/** Adaptador simples pgsql e atelie */
class RepositorioAdapter implements IRepositorio
{

  private array $objetos;
  private $conexao;

  public function __construct()
  {
    $this->objetos = array();

    $credenciais =  $this->obterStringConexaoDasVariaveisAmbientes();
    $this->conexao = pg_connect( $credenciais );
  }

  //---------------------------------------

  public function obterArrayObjetos(): array
  {
    return $this->objetos;
  }

  //---------------------------------------

  public function ler( string $consulta ): void
  {
    $this->objetos = array();
    $res = array();

    try
    {
      $res = pg_query( $this->conexao, $consulta );

      if ( $res === false )
      {
        throw new \Exception("ler: erro desconhecido.");
      }

      while ( $linha = pg_fetch_object( $res ) )
      {
        array_push( $this->objetos, $linha );
      }

      pg_free_result( $res );
    }
    catch( \Exception $error )
    {
      fwrite( STDERR, $error->getMessage() );
    }

  }

  public function escrever( string $ordem, array $dados ): void
  {
    try
    {
      pg_query_params( $this->conexao, $ordem, $dados );
    }
    catch( \Exception $error )
    {
      fwrite( STDERR, $error->getMessage() );
    }
  }

  //---------------------------------------

  public function redefinir(): void
  {
    $this->objetos = array();
  }

  public function encerrar(): void
  {
    pg_close( $this->conexao );
  }

  //---------------------------------------

  private function validarTipo( object $proposta, string $tipo ): void
  {
    if ( $proposta instanceof $tipo )
    {
      throw new \Exception( "Objeto proposto não é instância de: ".$tipo );
    }
  }

  //---------------------------------------

  private function obterStringConexaoDasVariaveisAmbientes(): string
  {
    $pghost     = getenv( "PG_HOST" );
    $pguser     = getenv( "PG_USER" );
    $pgdatabase = getenv( "PG_DATABASE" );
    $pgpass     = getenv( "PG_PASS" );

    switch ( true )
    {
      case ( $pghost instanceof string ):
        throw new \Exception( "Variável ambiente PG_HOST não definida" );
      case ( $pguser instanceof string ):
        throw new \Exception( "Variável ambiente PG_USER não definida" );
      case ( $pgdatabase instanceof string ):
        throw new \Exception( "Variável ambiente PG_DATABASE não definida" );
      case ( $pgpass instanceof string ):
        throw new \Exception( "Variável ambiente PG_PASS não definida" );
    }

    return "host=".$pghost." user=".$pguser." dbname=".$pgdatabase." password=".$pgpass;
  }

}


