<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Preco as Preco;

final class ValueObjectPrecoTest extends TestCase
{
  # DEVE FUNCIONAR

  public function testPrecoNulo()
  {
    $instancia = new Preco( 0.0, 1 );
    $this->assertEquals( 0.0, $instancia->obterPreco() );
  }

  public function testAlteracaoArbitrariaPreco()
  {
    $instancia = new Preco( 0.0, 1 );
    $instancia->alterarPreco( 1.0 );
    $this->assertEquals( 1.0, $instancia->obterPreco() );
  }

  public function testAumentoQuantidadeAfetaQuantidadeCorretamente()
  {
    $instancia = new Preco( 1.0, 1 );
    $instancia->aumentarQuantidade( 1 );
    $this->assertEquals( 2, $instancia->obterQuantidade() );
  }

  public function testAumentoQuantidadeAfetaPrecoCorretamente()
  {
    $instancia = new Preco( 1.0, 1 );
    $instancia->aumentarQuantidade( 1 );
    $this->assertEquals( 2.0, $instancia->obterPreco() );
  }

  public function testDiminuicaoQuantidadeAfetaPrecoCorretamente()
  {
    $instancia = new Preco( 1.0, 2 );
    $instancia->diminuirQuantidade( 1 );
    $this->assertEquals( 1.0, $instancia->obterPreco() );
  }

  # DEVE EXCEPCIONAR

  public function testQuantidadeMenorQueUmExcepciona()
  {
    $this->expectException( Throwable::class );
    $instancia = new Preco( 1.0, -1 );
  }

  public function testPrecoNegativoExcepciona()
  {
    $this->expectException( Throwable::class );
    $instancia = new Preco( -1.0, 1 );
  }

  public function testDiminuicaoSobreQuantidadeInsuficienteExcepciona()
  {
    $instancia = new Preco( 1.0, 1 );
    $this->expectException( Throwable::class );
    $instancia->diminuirQuantidade( 100 );
  }

  public function testDiminuicaoComNumeroNegativoExcepciona()
  {
    $instancia = new Preco( 1.0, 10 );
    $this->expectException( Throwable::class );
    $instancia->diminuirQuantidade( -5 );
  }

  public function testAumentoComNumeroNegativoExcepciona()
  {
    $instancia = new Preco( 1.0, 1 );
    $this->expectException( Throwable::class );
    $instancia->aumentarQuantidade( -9 );
  }

}


