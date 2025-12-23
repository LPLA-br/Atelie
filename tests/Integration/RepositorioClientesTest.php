<?php

use PHPUnit\Framework\TestCase;

use \Src\Domain\Repository\RepoCliente as RepoCliente;
use \Src\Domain\Repository\IRepositorio as IRepositorio;
use \Src\Domain\Repository\RepositorioAdapter as RepositorioAdapter;
use \Src\Domain\Entity\Cliente as Cliente;

final class RepositorioClientesTest extends TestCase
{
  public function testObterObjetosClienteFunciona()
  {
    $ra = new RepositorioAdapter();
    $rc = new RepoCliente( $ra );
    $rc->carregarTodosClientes();
    $objetos = $rc->obterObjetos();
    $rc->encerrar();

    $this->assertEquals( ($objetos[0] instanceof Cliente), true );
  }
}
