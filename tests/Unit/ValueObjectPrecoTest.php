<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Preco as Preco;

final class ValueObjectPrecoTest extends TestCase
{
  # DEVE FUNCIONAR

  public function testPrecoNuloFunciona()
  {
    $instancia = new Preco( 0.0 );
    $this->assertSame( 0.0, $instancia->obterPreco() );
  }

  public function testAlteracaoArbitrariaPrecoFunciona()
  {
    $instancia = new Preco( 0.0 );
    $instancia->definirNovoPreco( 1.0 );
    $this->assertSame( 1.0, $instancia->obterPreco() );
  }

  public function testZerarPrecoArbitrariamenteFunciona()
  {
    $instancia = new Preco( 1.0 );
    $instancia->zerarPreco();
    $this->assertSame( 0.0, $instancia->obterPreco() );
  }

  # DEVE EXCEPCIONAR

  public function testSubtracaoAbsurdaExcepciona()
  {
    $instancia = new Preco( 0.0 );
    $this->expectException( Throwable::class );
    $instancia->subtrair( 1000 );
  }

  public function testMultiplicacaoValorNegativoExcepciona()
  {
    $instancia = new Preco( 0.0 );
    $this->expectException( Throwable::class );
    $instancia->multiplicar( -1000 );
  }

  public function testSubtracaoValorNegativoExcepciona()
  {
    $instancia = new Preco( 0.0 );
    $this->expectException( Throwable::class );
    $instancia->subtrair( -1000 );
  }

  public function testIntanciacaoPrecoMenorZeroExcepciona()
  {
    $this->expectException( Throwable::class );
    $instancia = new Preco( -1.0 );
  }
}


