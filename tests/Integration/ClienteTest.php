<?php

use PHPUnit\Framework\TestCase;

use Src\Domain\Entity\Cliente as Cliente;

use Src\Domain\ValueObject\Contato as Contato;
use Src\Domain\ValueObject\Medida as Medida;
use Src\Domain\ValueObject\Endereco as Endereco;

final class ClienteTest extends TestCase
{
  public function testInstanciacaoPobreFunciona()
  {
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );
    $this->assertEquals( ($cliente instanceof Cliente), true );
  }

  public function testInstanciacaoContatilFunciona()
  {
    $contato = new Contato( "993456789", "mercio@teste.com" );
    $cliente = new Cliente( 1, "Mercio", $contato, NULL, NULL );
    $this->assertEquals( ($cliente instanceof Cliente), true );
  }

  public function testInstanciacaoMensuravelFunciona()
  {
    $medida = new Medida( '{"cintura":88.0,"peito":99.0}' );
    $cliente = new Cliente( 1, "Mercio", NULL, $medida, NULL );
    $this->assertEquals( ($cliente instanceof Cliente), true );
  }

  /* interditado temporariamente.
  public function testInstanciacaoEnderecavelFunciona()
  {
    $endereco = new Endereco(
      "Brasil",
      "RJ",
      "Jacaranaguaranara",
      "Padre Santo",
      "1 Abril",
      "123",
      NULL
    );
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );
    $this->assertEquals( ($cliente instanceof Cliente), true );
  }*/

  public function testObtencaoMedidaFunciona()
  {
    $medida = new Medida( '{"cintura":88.0,"peito":99.0}' );
    $cliente = new Cliente( 1, "Mercio", NULL, $medida, NULL );
    $medidas = $cliente->obterMedidas();
    $this->assertEqualsWithDelta( $medidas->cintura, 88.0, 0.1 );
    $this->assertEqualsWithDelta( $medidas->peito, 99.0, 0.1 );
  }
}

