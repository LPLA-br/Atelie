<?php

require './vendor/autoload.php';

use Src\Domain\Comunication\Servidor;

$servicoPrincipal = new Servidor( "127.0.0.1", "9999" );
$servicoPrincipal->ouvir();

