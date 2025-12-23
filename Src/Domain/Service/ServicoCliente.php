<?php

use \Src\Domain\Repository\RepoCliente;
use \Src\Domain\Repository\RepositorioAdapter;

/* Use cases para manipulação informacional de clientes */
class ServicoCliente
{

  public function __construct()
  {
    
  }

  //---- read

  public function obterDados(): object
  {
    return (object) array();
  }

  //----- use cases

  public function  alterarMedidas(): void
  {}

  //--------------------

}

