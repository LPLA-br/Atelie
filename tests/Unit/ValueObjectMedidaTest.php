<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Medida as Medida;

final class ValueObjectMedidaTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $m = new Medida( '{"cintura": 25.0,"quadril":80.0}' );
    $this->assertEquals( ($m instanceof Medida), true );
  }

  public function testInteirosExcepcionam()
  {
    $this->expectException( Throwable::class );
    $m = new Medida( '{"cintura": 25,"quadril":80.0}' );
  }

  public function testNaoNumerosExcepcionam()
  {
    $this->expectException( Throwable::class );
    $m = new Medida( '{"cintura": NULL,"quadril":80.0}' );
    $m = new Medida( '{"cintura": {"a":10},"quadril":80.0}' );
    $m = new Medida( '{"cintura": "fail","quadril":80.0}' );
    $m = new Medida( '{"cintura": 0,"quadril":80.0}' );
  }
}
