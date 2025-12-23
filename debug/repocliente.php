<?php

//carrege arquivo de variáveis ambientes correspondentes

require "./Src/Domain/Repository/RepoCliente.php";
require "./Src/Domain/Repository/IRepositorio.php";
require "./Src/Domain/Repository/RepositorioAdapter.php";

$ra = new \Src\Domain\Repository\RepositorioAdapter(); // OK
$cr = new \Src\Domain\Repository\RepoCliente( $ra );

