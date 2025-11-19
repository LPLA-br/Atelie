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
use Src\Domain\Enum\EPecaTipo as EPecaTipo;
use Src\Domain\Enum\EPecaEstado as EPecaEstado;

use Src\Domain\Collection\PecasColecao as PecasColecao;

final class PecasCollectionTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $insumos2 = [
      new InsumoUnitario( 203, "ziper",    new Preco( 2.0, 1 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 50.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo2 = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta nova",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Pendente,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecaColecao = new PecasColecao( $pecas );

    $this->assertEquals( ($pecaColecao instanceof PecasColecao), false );
  }

  public function testBuscarLinearmentePeloTipoFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $insumos2 = [
      new InsumoUnitario( 203, "ziper",    new Preco( 2.0, 1 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 50.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo2 = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta nova",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Pendente,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecaColecao = new PecasColecao( $pecas );
    $resultado = $pecaColecao->buscarPeloTipo( EPecaTipo::Calsao );

    $this->assertEquals( $resultado->obterTipo(), EPecaTipo::Calsao );
  }

  public function testBuscarLinearmentePeloEstado()
  { 
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $insumos2 = [
      new InsumoUnitario( 203, "ziper",    new Preco( 2.0, 1 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 50.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo2 = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta nova",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Concluida,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecaColecao = new PecasColecao( $pecas );
    $resultado = $pecaColecao->buscarPeloEstado( EPecaEstado::Pendente );

    $this->assertEquals( $resultado, EPecaEstado::Pendente );
  }

  public function testComputarCustoTotalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido",   new Preco( 120.0, 2.1 ) )
    ];

    $insumos2 = [
      new InsumoUnitario( 203, "ziper",    new Preco( 2.0, 1 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 50.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo2 = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta nova",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Concluida,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecaColecao = new PecasColecao( $pecas );
    $custototal = $pecaColecao->computarCustoTotal();

    $this->assertEqualsWithDelta( $custototal, (0.50*2+1.0*5+120.0*2.1+(2.0)+50.0*2.1), 1 );
  }

  public function testObterPecaComMaiorPrazoFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $insumos2 = [
      new InsumoUnitario( 203, "ziper",    new Preco( 2.0, 1 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 50.0, 2.1 ) )
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo2 = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta nova",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Concluida,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecaColecao = new PecasColecao( $pecas );
    $maiorPrazo = $pecaColecao->obterPecaMaiorPrazo();

    $this->assertEquals( $maiorPrazo, $peca2->obterPrazo() );
  }
}

