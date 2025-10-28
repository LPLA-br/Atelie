<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Preco as Preco;
use Src\Domain\Entity\InsumoUnitario as InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado as InsumoQuadrado;
use Src\Domain\Collection\InsumosColecao as InsumosColecao;

class Alienigena {};

/* Este teste considera que testes de classes folha e galhos
 * dependidos foram testados. Este teste não utiliza mocks. */
final class InsumosCollectionTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $this->assertIsObject( $ic );
  }

  public function testBuscaPorIdFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $resultado = $ic->buscarPorId( 162 );

    $this->assertEquals( $resultado->obterId(), 162 );
  }


  public function testBuscaPorNomeFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $resultado = $ic->buscarPorNome( "botão" );

    $this->assertEquals( $resultado->obterId(), 162 );
  }

  public function testRemocaoPorIdFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $ic->removerPorId( 162 );
    $resultado = $ic->buscarPorId( 162 );

    $this->assertEquals( $resultado, NULL );
  }

  public function testRemocaoPorNomeFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $ic->removerPorNome( "botão" );
    $resultado = $ic->buscarPorNome( "botão" );

    $this->assertEquals( $resultado, NULL );
  }

  public function testSubstituirPorIdFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $ic->substituirPorId( 441 ,new InsumoUnitario( 441, "grampo", new Preco( 0.25, 5 ) ) );
    $resultado = $ic->buscarPorId( 441 );

    $this->assertEquals( $resultado->obterNome(), "grampo" );
  }

  public function testSubstituirPorNomeFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $ic->substituirPorNome( "botão", new InsumoUnitario( 441, "grampo", new Preco( 0.25, 5 ) ) );
    $resultado = $ic->buscarPorNome( "grampo" );

    $this->assertEquals( $resultado->obterNome(), "grampo" );
  }

  public function testObterSomatorioCustoTodosInsumosFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50,  2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0,   5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0,  1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $this->assertEquals( $ic->obterSomatorioCustoTodosInsumos(), (0.50*2 + 1.0*5 + 120.0*2.1 + 80.0*1.5) );
  }

  public function testObterContagemInsumosUnitariosFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50,  2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0,   5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0,  1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $this->assertEquals( $ic->obterContagemInsumosUnitarios(), (7) );
  }

  public function testObterSomatorioAreaInsumosQuadradosFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50,  2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0,   5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0,  1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );

    $this->assertEquals( $ic->obterSomatorioAreaInsumosQuadrados(), (2.1 + 1.5) );
  }

  // DEVE EXCEPCIONAR

  /* Objeto "Alienigena" = não descendente de AInsumo */
  public function testObjetosAlienigenaExcepciona()
  {
    

    $insumos = [
      new Alienigena(),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0,   5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0,  1.5 ) ),
    ];

    $this->expectException( Throwable::class );
    $ic = new InsumosColecao( $insumos );
  }

  public function testAdicionarObjetoAlienigenaExcepciona()
  {
    
    $insumos = [
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0,   5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0,  1.5 ) ),
    ];

    $this->expectException( Throwable::class );
    $ic = new InsumosColecao( $insumos );
    $ic->adicionar( new Alienigena() );
  }

  public function testNomesRepetidosExepciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50,  2 ) ),
      new InsumoUnitario( 162, "botão",    new Preco( 0.25,  4 ) ),
      new InsumoUnitario( 162, "botão",    new Preco( 0.35,  8 ) ),
    ];

    $this->expectException( Throwable::class );

    $ic = new InsumosColecao( $insumos );
  }

  public function testAdicaoMesmoIdExcepciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );
    $this->expectException( Throwable::class );
    $ic->adicionar( new InsumoUnitario( 162, "pino", new Preco( 0.50, 2 ) ) );
  }

  public function testAdicaoMesmoNomeExcepciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido A", new Preco( 120.0, 2.1 ) ),
      new InsumoQuadrado( 441, "tecido B", new Preco( 80.0, 1.5 ) ),
    ];

    $ic = new InsumosColecao( $insumos );
    $this->expectException( Throwable::class );
    $ic->adicionar( new InsumoUnitario( 007, "botão", new Preco( 0.50, 2 ) ) );
  }

}
