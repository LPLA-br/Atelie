<?php

require "./Src/Domain/ValueObject/Prazo.php";

$p = new \Src\Domain\ValueObject\Prazo( new DateTime( date('Y-m-d') )->modify('+10 days')->format('Y-m-d') );

