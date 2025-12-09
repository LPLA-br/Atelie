<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<meta name="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="aplicação ateliê">
		<link rel="stylesheet" href="./global.css">
		<title> Ateliê </title>
	</head>
  <body>
    <header class="cabecalho">
      <h1> ATELIÊ </h1>
      <nav>
        <li class="linkcontainer"> <a href="./clientes.php"> clientes </a> </li>
      </nav>
    </header>

    <main class="conteudo">
<?php
  require '../vendor/autoload.php';

  use Src\Domain\ValueObject\Preco as IPreco;
  use Src\Domain\ValueObject\Preco as Preco;

  $a = new \Src\Domain\ValueObject\Preco( 0.50, 10 );
  echo $a->obterPreco();
?> 
    </main>
    <footer class="rodape"> lpla-br copyright © 2025 </footer>
  </body
</html>
