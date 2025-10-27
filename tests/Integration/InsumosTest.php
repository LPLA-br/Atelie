<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Preco as Preco;
use Src\Domain\Entity\InsumoUnitario as InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado as InsumoQuadrado;

/* Integra-se com:
 *  InsumoQuadrado ou InsumoUnitario
 *  IPreco
 * */

final class InsumosTest extends TestCase
{
  public function testInstanciacaoNormalAmbosFunciona()
  {
    $pu = new Preco( 0.50, 2 );
    $pq = new Preco( 120.0, 2.1 );

    $qu = new InsumoUnitario( 1, "botão",  $pu );
    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $this->assertEquals( $qu->obterId(), 1 );
    $this->assertEquals( $qq->obterId(), 2 );
  }

  public function testObterInformacoesAInsumoFunciona()
  {
    $pu = new Preco( 0.50, 2 );
    $pq = new Preco( 120.0, 2.1 );

    $qu = new InsumoUnitario( 1, "botão",  $pu );
    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $this->assertEquals( $qu->obterCusto(), 1.0 );
    $this->assertEquals( $qq->obterCusto(), 252 );

    $this->assertEquals( $qu->obterId(), 1 );
    $this->assertEquals( $qq->obterId(), 2 );

    $this->assertEquals( $qu->obterCusto(), (0.50 * 2) );
    $this->assertEquals( $qq->obterCusto(), (120.0 * 2.1) );
  }

  public function testObterInformacoesInsumoQuadradoFunciona()
  {
    $pq = new Preco( 120.0, 2.1 );
    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $this->assertEquals( $qq->obterMetrosQuadrados(), (2.1) );
  }

  public function testObterInformacoesInsumoUnitarioFunciona()
  {
    $pu = new Preco( 0.5, 6 );
    $qu = new InsumoUnitario( 2, "botão", $pu );

    $this->assertEquals( $qu->obterQuantidadeUnidades(), (6) );
  }

  public function testInsumoQuadradoAumentaArea()
  {
    $pq = new Preco( 1.0, 1.5 );

    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $qq->aumentarArea( 0.5 );
    $this->assertEquals( $qq->obterMetrosQuadrados(), 2.0 );
  }

  public function testInsumoQuadradoDiminuiArea()
  {
    $pq = new Preco( 1.0, 1.5 );

    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $qq->diminuirArea( 0.5 );
    $this->assertEquals( $qq->obterMetrosQuadrados(), 1.0 );
  }

  # DEVE EXCEPCIONAR
  
  public function testInsumoQuadradoDiminuirAreaAlemExepciona()
  {
    $pq = new Preco( 1.0, 1.5 );

    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $this->expectException( Throwable::class );
    $qq->diminuirArea( 20.0 );
  }

  public function testInsumoQuadradoDiminuirAreaReversamenteExepciona()
  {
    $pq = new Preco( 1.0, 10.5 );

    $qq = new InsumoQuadrado( 2, "tecido", $pq );

    $this->expectException( Throwable::class );
    $qq->diminuirArea( -1.0 );
  }

  public function testeInsumoUnitarioDiminuirQuantidadeAlemExcepciona()
  {
    $pq = new Preco( 1.0, 1 );

    $qq = new InsumoUnitario( 2, "botão", $pq );

    $this->expectException( Throwable::class );
    $qq->diminuirUnidades( 10 );
  }

  public function testeInsumoUnitarioDiminuirQuantidadeReversamenteExcepciona()
  {
    $pq = new Preco( 1.0, 6 );

    $qq = new InsumoUnitario( 2, "botão", $pq );

    $this->expectException( Throwable::class );
    $qq->diminuirUnidades( -2 );
  }
}

