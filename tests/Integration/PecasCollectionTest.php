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
    $pecasColecao = new PecasColecao( $pecas );

    $this->assertEquals( $pecasColecao->obterNumeroElementos(), 2 );
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
    $pecasColecao = new PecasColecao( $pecas );
    $resultado = $pecasColecao->buscarPeloTipo( EPecaTipo::Calsao );

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
    $pecasColecao = new PecasColecao( $pecas );
    $resultado = $pecasColecao->buscarPeloEstado( EPecaEstado::Pendente );

    $this->assertEquals( ($resultado instanceof Peca), true );
    $this->assertEquals( $resultado->obterEstado(), EPecaEstado::Pendente );
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
    $pecasColecao = new PecasColecao( $pecas );
    $custototal = $pecasColecao->computarCustoTotal();

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
    $pecasColecao = new PecasColecao( $pecas );
    $maiorPrazo = $pecasColecao->obterPrazoDaPecaMaiorPrazo();

    $this->assertEquals( $maiorPrazo, $peca2->obterPrazo() );
  }

  public function testObterPecasPendentesFunciona()
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
    $pecasColecao = new PecasColecao( $pecas );

    $pecasPendentes = $pecasColecao->obterPecasPendentes();
    $quantidadePecasPendentes = $pecasColecao->obterQuantidadePecasPendentes();
    
    $this->assertEquals( is_array( $pecasPendentes ), true );
    for ( $i = 0; $i < sizeof($pecasPendentes); $i++ )
    {
      $this->assertEquals( ($pecasPendentes[$i] instanceof Peca), true );
    }
    $this->assertEquals( $quantidadePecasPendentes, 2 );
  }

  public function testObterPecasConcluidasFunciona()
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
      EPecaEstado::Concluida,
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
    $pecasColecao = new PecasColecao( $pecas );

    $pecasConcluidas = $pecasColecao->obterPecasConcluidas();
    $quantidadePecasConcluidas = $pecasColecao->obterQuantidadePecasConcluidas();
    
    $this->assertEquals( is_array( $pecasConcluidas ), true );
    for ( $i = 0; $i < sizeof($pecasConcluidas); $i++ )
    {
      $this->assertEquals( ($pecasConcluidas[$i] instanceof Peca), true );
    }
    $this->assertEquals( $quantidadePecasConcluidas, 2 );
  }

  public function testObterPecasProgredintesFunciona()
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
      EPecaEstado::Progredinte,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      2,
      "calsão novo",
      EPecaTipo::Calsao,
      EPecaEstado::Progredinte,
      $prazo2,
      new InsumosColecao( $insumos2 )
    );

    $pecas = [ $peca, $peca2 ];
    $pecasColecao = new PecasColecao( $pecas );

    $pecasProgredintes = $pecasColecao->obterPecasProgredintes();
    $quantidadePecasProgredintes = $pecasColecao->obterQuantidadePecasProgredintes();
    
    $this->assertEquals( is_array( $pecasProgredintes ), true );
    for ( $i = 0; $i < sizeof($pecasProgredintes); $i++ )
    {
      $this->assertEquals( ($pecasProgredintes[$i] instanceof Peca), true );
    }
    $this->assertEquals( $quantidadePecasProgredintes, 2 );
  }
}

