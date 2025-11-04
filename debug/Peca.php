<?php

require "./Src/Domain/Entity/AInsumo.php";
require "./Src/Domain/Entity/InsumoUnitario.php";
require "./Src/Domain/Entity/InsumoQuadrado.php";

require "./Src/Domain/ValueObject/IPreco.php";
require "./Src/Domain/ValueObject/Preco.php";

require "./Src/Domain/Collection/InsumosColecao.php";

require "./Src/Domain/Entity/Peca.php";

require "./Src/Domain/Enum/EPecaEstado.php";
require "./Src/Domain/Enum/EPecaTipo.php";

$p1 = new \Src\Domain\ValueObject\Preco( 0.50, 5 );
$p2 = new \Src\Domain\ValueObject\Preco( 2.00, 1 );
//----------------------------------------------------
$p3 = new \Src\Domain\ValueObject\Preco( 120.00, 2.5 );

$u1 = new \Src\Domain\Entity\InsumoUnitario( 167, "botão", $p1 );
$u2 = new \Src\Domain\Entity\InsumoUnitario( 424, "ziper", $p2 );
//-------------------------------------------------------------
$u3 = new \Src\Domain\Entity\InsumoQuadrado( 356, "tecido", $p3 );

$c =  new \Src\Domain\Collection\InsumosColecao( [ $u1, $u2, $u3 ] );

$p = new \Src\Domain\Entity\Peca( 34, "camiseta de fulano", EPecaTipo::Camiseta, EPecaEstado::Pendente, $c );

