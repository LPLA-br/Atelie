<?php

namespace \Src\Domain\Repository;

use \Src\Domain\Entity\AInsumo;

class RepoInsumo extends RepoGenerico
{
  public function __construct()
  {
    parent::__construct();    
  }

  public function ler( int $id ): void
  {
    $this->representacao = array();
  }

  public function escrever(): void
  {}

  //-----------------------------

  private function buscarInsumo( int $id ): object
  {
    $query = "SELECT * FROM insumos";
    pg_query( $this->conexao, $query );
  }
  
}

