<?php

use PHPUnit\Framework\TestCase;

use Src\Domain\ValueObject\Preco as Preco;
use Src\Domain\ValueObject\Prazo as Prazo;

use Src\Domain\Entity\InsumoUnitario as InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado as InsumoQuadrado;

use Src\Domain\Collection\InsumosColecao as InsumosColecao;

use Src\Domain\Enum\EPecaTipo as EPecaTipo;
use Src\Domain\Enum\EPecaEstado as EPecaEstado;


/* Este teste considera que testes de classes folha e galhos
 * dependidos foram testados. Este teste não utiliza mocks. */
final class InsumosCollectionTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $insumos = [
      new InsumoUnitario( 162, "botão",    new Preco( 0.50, 2 ) ),
      new InsumoUnitario( 203, "ziper",    new Preco( 1.0, 5 ) ),
      new InsumoQuadrado( 332, "tecido", new Preco( 120.0, 2.1 ) )
    ];

    $peca = new Peca(
      1, "camiseta de fulano",
      EPecaTipo::Camiseta, EPecaEstado::Pendente,
      new InsumosColecao( $insumos )
    );

  }

  // DEVE EXPECIONAR

  public function testExepciona()
  {
    $this->expectException( Throwable::class );
  }

}
