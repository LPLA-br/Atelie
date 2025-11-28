<?php

namespace \Src\Domain\Repository;

abstract class RepoGenerico
{

  protected object | NULL $representacao;
  protected $conexao;

  public function __construct()
  {
    $this->representacao = NULL;
    $this->conexao = pg_connect( $this->obterStringConexaoDasVariaveisAmbientes() );
  }

  /** Busca, insância e carrega representação na memória */
  abstract public function ler( int $id ): void;

  /** Salva representação corrente no banco de dados */
  abstract public function escrever(): void;

  public function obterRepresentacao(): object
  {
    return $this->representacao;
  }

  //---------------------------------------

  protected function obterStringConexaoDasVariaveisAmbientes()
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

  protected function encerrar(): void
  {
    pg_close( $this->conexao );
  }

  //---------------------------------------

  protected function validarAcaoEscrita(): void
  {
    if ( !$this->eNulaRepresentacao() )
    {
      return;
    }
    throw new \Exception( "escrever: escrita negada pois representacao é nula." );
  }

  //---------------------------------------

  protected function eNulaRepresentacao(): bool
  {
    return ( $this->representacao === NULL );
  }

}


