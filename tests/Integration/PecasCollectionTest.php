<?php

use PHPUnit\Framework\TestCase;

use Src\Domain\ValueObject\Preco as Preco;
use Src\Domain\ValueObject\Prazo as Prazo;

use Src\Domain\Entity\InsumoUnitario as InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado as InsumoQuadrado;

use Src\Domain\Collection\InsumosColecao as InsumosColecao;

use Src\Domain\Enum\EPecaTipo as EPecaTipo;
use Src\Domain\Enum\EPecaEstado as EPecaEstado;

use Src\Domain\Entity\Peca as Peca;


/* Este teste considera que testes de classes folha e galhos
 * dependidos foram testados. Este teste não utiliza mocks. */
final class PecasCollectionTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $this->assertEquals( ($peca === NULL ? true : false), false );
  }

  public function testFluxoDeEstadosNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $this->assertEquals( ( $peca->obterEstado() === EPecaEstado::Pendente ? true : false ), true );
    $peca->iniciarTrabalhoPeca();
    $this->assertEquals( ( $peca->obterEstado() === EPecaEstado::Progredinte ? true : false ), true );
    $peca->suspenderTrabalhoPeca();
    $this->assertEquals( ( $peca->obterEstado() === EPecaEstado::Pendente ? true : false  ), true );
    $peca->iniciarTrabalhoPeca();
    $this->assertEquals( ( $peca->obterEstado() === EPecaEstado::Progredinte ? true : false ),  true );
    $peca->concluirPeca();
    $this->assertEquals( ( $peca->obterEstado() === EPecaEstado::Concluida ? true : false ), true );
  }

  public function testInformacoesPrecoFuncionam()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $this->assertEquals( $peca->obterCustoTodosInsumos(), (0.50*2 + 1.0*5 + 120.0*2.1) );
  }

  // DEVE EXPECIONAR

  public function testIniciarTrabalhoPecaAbortadaExepciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca->abortarPeca();
    $this->expectException( Throwable::class );
    $peca->iniciarTrabalhoPeca();
  }

  public function testIniciarTrabalhoPecaConcluidaExepciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $this->expectException( Throwable::class );
    $peca->concluirPeca();
    $peca->iniciarTrabalhoPeca();
  }

}
