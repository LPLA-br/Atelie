<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Prazo as Prazo;

final class ValueObjectPrazoTest extends TestCase
{
  # DEVE FUNCIONAR

  public function testInstanciacaoNormalFunciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );
    $this->assertInstanceOf( Prazo::class , $instancia );
  }

  public function testDefinicaoDataPrazoEncurtamentoFunciona()
  {

    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );

    $dateTime->modify("-4 days");
    $instancia->definirPrazo( $dateTime->format("Y-m-d") );

    $this->assertEquals( $instancia->obterPrazo(),  $dateTime->format("Y-m-d")  );
  }

  public function testDefinicaoDataPrazoAlogamentoFunciona()
  {

    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );

    $dateTime->modify("+14 days");
    $instancia->definirPrazo( $dateTime->format("Y-m-d") );

    $this->assertEquals( $instancia->obterPrazo(),  $dateTime->format("Y-m-d")  );
  }

  public function testIndeterminarPrazoFunciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );

    $instancia->indeterminarPrazo();

    $this->assertEquals( $instancia->estaIndeterminado(),  true  );
  }

  public function testRedeterminarPrazoFunciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );

    $instancia->indeterminarPrazo();
    $instancia->restaurarPrazo();

    $this->assertEquals( $instancia->estaIndeterminado(),  false  );
  }

  public function testRedeterminarPrazoDefineDiaSeguinteFunciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );

    $instancia->indeterminarPrazo();
    $instancia->restaurarPrazo();

    $amanha = new DateTime( date("Y-m-d") )->modify("+1 days")->format("Y-m-d");
    $this->assertEquals( $instancia->obterPrazo(), $amanha );
  }

  public function testPrazoAtrasadoEstaUltrapassadoFunciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("-7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );
    $this->assertEquals( $instancia->, );
  }


  # DEVE EXCEPCIONAR

  public function testRedefinicaoDataPrazoAnteriorExcepciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $instancia = new Prazo( $dateTime->format("Y-m-d") );
    $this->expectException( Throwable::class );
    $instancia->definirPrazo( $dateTime->modify("-14 days")->format("Y-m-d") );
  }

  public function testInstanciacaoComDataInvalidaExcepciona()
  {
    $dateTime = new DateTime( date("Y-m-d") );
    $dateTime->modify("+7 days");

    $this->expectException( Throwable::class );
    $instancia = new Prazo( "00-0-0" );
  }
}

