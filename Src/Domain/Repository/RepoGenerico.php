<?php

namespace \Src\Domain\Repository;

abstract class RepoGenerico
{

  protected array $resultado;
  protected $conexao;
  private bool $somenteLeitura;

  public function __construct( array $objetos )
  {
    $this->resultado = array();
    $this->conexao = pg_connect( $this->obterStringConexaoDasVariaveisAmbientes() );

    if ( sizeof($objetos) > 0 )
    {
      $this->somenteLeitura = false;
      $this->resultado = $objetos;
      return;
    }

    $this->somenteLeitura = true;
  }

  /** Retorna lista de derivados de AInsumo instânciados.*/
  abstract public function obterObjetos(): array;

  //---------------------------------------

  public function obterArrayResultados(): array
  {
    return $this->resultado;
  }

  //---------------------------------------

  protected function ler( string $consulta ): void
  {
    $this->invalidarLeiturasPorSomenteEscrita();

    $this->resultado = array();
    $res = pg_query( $this->conexao, $consulta );

    if ( $res === false )
    {
      throw new \Exception("ler: erro desconhecido.");
    }

    while ( $linha = pg_fetch_row( $res ) )
    {
      array_push( $this->resultado, $linha );
    }

    pg_free_result( $res );
  }

  protected function escrever( string $consulta ): void
  {
    $this->invalidarEscritasPorSomenteLeitura();
    if ( pg_query( $this->conexao, $consulta ) === false )
    {
      throw new \Exception("escrever: erro desconhecido.");
    }
  }

  //---------------------------------------

  protected function encerrar(): void
  {
    pg_close( $this->conexao );
  }

  //---------------------------------------

  protected function invalidarLeiturasPorSomenteEscrita(): void
  {
    if ( $this->eRepositorioSomenteEscrita() )
    {
      throw new \Exception( "Ação negada: Repositório somente escrita." );
    }
  }

  protected function invalidarEscritasPorSomenteLeitura(): void
  {
    if ( !$this->eRepositorioSomenteEscrita() )
    {
      throw new \Exception( "Ação negada: Repositório somente leitura." );
    }
  }

  //---------------------------------------

  protected function validarTipo( object $proposta, string $tipo ): void
  {
    if ( $proposta instanceof $tipo )
    {
      throw new \Exception( "Objeto proposto não é instância de: ".$tipo );
    }
  }

  //---------------------------------------

  private function obterStringConexaoDasVariaveisAmbientes(): void
  {
    $pghost     = getenv( "PG_HOST" );
    $pguser     = getenv( "PG_USER" );
    $pgdatabase = getenv( "PG_DATABASE" );
    $pgpass     = getenv( "PG_PASS" );

    switch ( true )
    {
      case ($pghost === NULL):
        throw new \Exception( "Variável ambiente PG_HOST não definida" );
      case ($pguser === NULL):
        throw new \Exception( "Variável ambiente PG_USER não definida" );
      case ($pgdatabase === NULL):
        throw new \Exception( "Variável ambiente PG_DATABASE não definida" );
      case ($pgpass === NULL):
        throw new \Exception( "Variável ambiente PG_PASS não definida" );
    }

    return "host=".$pghost." user=".$pguser." dbname=".$pgname." password=".$pgpass;
  }

  //---------------------------------------
  
  private function eRepositorioSomenteEscrita(): bool
  {
    return !$this->somenteLeitura;
  }


}


