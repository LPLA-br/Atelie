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

use Src\Domain\Entity\ServicoCostureira as ServicoCostureira;


/* Este teste considera que testes de classes folha e galhos
 * dependidos foram testados. Este teste não utiliza mocks. */
final class ServicoCostureiraTest extends TestCase
{
  public function testAguardandoTesteDePecasCollection()
  {
    $this->assertEquals( true, true );
  }
/*public function testInstanciacaoNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido",   new Preco( 120.0, 2.1 ) )
    ];

    $insumosB = [
      new InsumoUnitario( 142, "botão",    new Preco( 0.90, 7 ) ),
      new InsumoUnitario( 202, "ziper",    new Preco( 1.6, 3 ) ),
    ];

    $formato = "Y-m-d";
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+1 days')->format( $formato ) );
    $prazo = new Prazo( new \DateTime( date( $formato ) )->modify('+2 days')->format( $formato ) );

    $peca = new Peca(
      1,
      "camiseta de fulano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );

    $peca2 = new Peca(
      1,
      "camiseta de sicrano",
      EPecaTipo::Camiseta,
      EPecaEstado::Pendente,
      $prazo,
      new InsumosColecao( $insumos )
    );
    
    $pecas = new PecasColecao()
    $servico = new ServicoCostureira( 1,  );
  }
*/
}
