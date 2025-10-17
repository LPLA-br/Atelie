<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Prazo as Prazo;

/* Integra-se com:
 *  InsumoQuadrado ou InsumoUnitario
 *  IPreco
 * */

final class InsumosTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $this->assertEquals( true, true );
  }
}

