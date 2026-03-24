<?php

require './vendor/autoload.php';

use Src\Domain\Comunication\Servidor;

$servicoPrincipal = new Servidor( getenv( "ATELIE_INTERFACE_IP" ), (int)getenv( "ATELIE_UDP_PORT" ) );
$servicoPrincipal->ouvir();

