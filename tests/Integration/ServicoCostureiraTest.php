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

use Src\Domain\Service\ServicoCostureira as ServicoCostureira;
use Src\Domain\Enum\EServicoTipo as EServicoTipo;
use Src\Domain\Enum\EServicoEstado as EServicoEstado;

use Src\Domain\Entity\Cliente as Cliente;


/* Este teste considera que testes de classes folha e galhos
 * dependidos foram testados. Este teste não utiliza mocks. */
final class ServicoCostureiraTest extends TestCase
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
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );

    $pecasColecao = new PecasColecao( $pecas );

    $servico = new ServicoCostureira(
      1,
      EServicoTipo::Conserto,
      EServicoEstado::Pendente,
      $cliente,
      $pecasColecao
    );

    $this->assertEquals( ($servico instanceof ServicoCostureira), true );
  }

  public function testAlteracaoEstadosNormalFunciona()
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
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );

    $pecasColecao = new PecasColecao( $pecas );

    $servico = new ServicoCostureira(
      1,
      EServicoTipo::Conserto,
      EServicoEstado::Pendente,
      $cliente,
      $pecasColecao
    );

    $this->assertEquals( ($servico->obterEstado()), EServicoEstado::Pendente );
    $servico->iniciar();
    $this->assertEquals( ($servico->obterEstado()), EServicoEstado::Progredinte );
    $servico->pausar();
    $this->assertEquals( ($servico->obterEstado()), EServicoEstado::Pendente );
    $servico->continuar();
    $this->assertEquals( ($servico->obterEstado()), EServicoEstado::Progredinte );
    $servico->concluir();
    $this->assertEquals( ($servico->obterEstado()), EServicoEstado::Concluido_parcialmente );

    $this->assertEquals( true, true );
  }

  public function testConcluirAbortadoExcepciona()
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
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );

    $pecasColecao = new PecasColecao( $pecas );

    $servico = new ServicoCostureira(
      1,
      EServicoTipo::Conserto,
      EServicoEstado::Abortado,
      $cliente,
      $pecasColecao
    );

    $this->expectException( Throwable::class );
    $servico->concluir();
  }

  public function testConcluirPendenteExcepciona()
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
    $cliente = new Cliente( 1, "Mercio", NULL, NULL, NULL );

    $pecasColecao = new PecasColecao( $pecas );

    $servico = new ServicoCostureira(
      1,
      EServicoTipo::Conserto,
      EServicoEstado::Pendente,
      $cliente,
      $pecasColecao
    );

    $this->expectException( Throwable::class );
    $servico->concluir();
  }

  // Setor de peças -> ./PecasCollectionTest.php

}
