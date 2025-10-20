<?php

require "./Src/Domain/Entity/AInsumo.php";

require "./Src/Domain/ValueObject/IPreco.php";
require "./Src/Domain/ValueObject/Preco.php";

require "./Src/Domain/Entity/InsumoUnitario.php";


$p = new \Src\Domain\ValueObject\Preco( 0.50, 5 );
$u = new \Src\Domain\Entity\InsumoUnitario( 1, "botão", $p );

