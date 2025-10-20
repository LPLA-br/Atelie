<?php

require "./Src/Domain/Entity/AInsumo.php";

require "./Src/Domain/ValueObject/IPreco.php";
require "./Src/Domain/ValueObject/Preco.php";

require "./Src/Domain/Entity/InsumoQuadrado.php";

$p = new \Src\Domain\ValueObject\Preco( 120, 1 );
$q = new \Src\Domain\Entity\InsumoQuadrado( 1, "linho", $p );

