<?php

namespace Src\Domain\Repository;

use \Src\Domain\Repository\IRepositorio;
use \Src\Domain\Repository\RepositorioAdapter;

use \Src\Domain\Entity\Cliente;
use \Src\Domain\ValueObject\Medida;

class RepoCliente
{

  private IRepositorio $repo;
  private bool $encerrado;

  public function __construct( IRepositorio $repo )
  {
    $this->repo = $repo;
    $this->encerrado = false;
  }

  public function obterObjetos(): array
  {

    if ( $this->encerrado === true )
    {
      return array();
    }

    $clientesRetorno = $this->repo->obterArrayObjetos();
    $retorno = array();

    if ( !is_array($clientesRetorno) )
    {
      throw new \Exception( "obterObjetos: consulta retornou não lista" );
    }

    for ( $i=0; $i<sizeof($clientesRetorno); $i++ )
    {
      $id = (int)($clientesRetorno[ $i ]->id);
      $nome = $clientesRetorno[ $i ]->nome;

      //uso futuro.
      //$endereco = $clientesRetorno[ $i ][ "endereco" ];
      //$contato = $clientesRetorno[ $i ][ "contato" ];
      $medida = $clientesRetorno[ $i ]->medida;

      array_push( $retorno,
        new Cliente(
          $id,
          $nome,
          NULL, //contato
          new Medida( $medida ),
          NULL //endereco
      ));
      continue;
    }
    return $retorno;
  }

  public function encerrar(): void
  {
    $this->encerrar = true;
    $this->repo->encerrar();
  }

  //-------------------------------------
  //postgres leitura

  public function carregarTodosClientes(): void
  {
    $this->repo->ler( "SELECT * FROM clientes" );
  }

  public function carregarCliente( int $id ): void
  {
    $this->repo->ler( "SELECT * FROM clientes WHERE id=".$id );
  }

  //postgres escrita

  public function registrarNovoCliente( Cliente $cliente ): void
  {
    $comandoEscrita =  "INSERT INTO clientes(nome,medida) VALUES ($1,$2)";
    $dados = [ $cliente->obterNome(), $cliente->obterMedida() ];

    $this->repo->escrever( $comandoEscrita, $dados );
  }

  public function atualizarRegistroCliente( int $id, Cliente $cliente ): void
  {
    $comandoAtualizacao = "UPDATE clientes SET nome=$1, medida=$2 WHERE id=$3";
    $dados = [  $cliente->obterNome(), $cliente->obterMedida(), $id ];

    $this->repo->escrever( $comandoAtualizacao, $dados );
  }

  public function removerCliente( $id ): void
  {
    $comandoDelecao = "DELETE FROM clientes WHERE id=$1";
    $dados = [ $id ];

    $this->repo->escrever( $comandoDelecao, $dados );
  }

  //-------------------------------------
  //extensão
  
}

