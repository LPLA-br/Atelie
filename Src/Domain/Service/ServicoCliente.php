<?php

use Src\Domain\Repository\RepositorioAdapter;
use Src\Domain\Repository\RepoCliente;
use Src\Domain\Entity\Cliente;

/* Use cases para manipulação informacional de clientes
 *
 * Recebe: struct Cliente
 * Retorna: struct Resposta stringficada do serviço cliente
 * Modo de vida: construção->ação->destruição
 * */
class ServicoCliente
{

	/** {sujeito:string, verbo:string, objeto:stringfiedJSON} */
	private object $svo;
	private Cliente $cliente;

  public function __construct( object $svo )
  {
    $this->svo = $svo;
  }

	// MÉTODOS

	/** Recebe: dados "object" do cliente. */
	public function registarCliente(): string
	{
		try
		{
			$cliente = new Cliente(
				-1,
				$svo["objeto"]["nome"],
				( $svo["objeto"]["contato"] ? $svo["objeto"]["contato"] : array() ),
				NULL,
				NULL
			);

			$repositorioCliente = new RepoCliente();
			$repositorioCliente->registrarNovoCliente( $cliente );
			$repositorioCliente->encerrar();

			return "OK";
		}
		catch ( Throwable $e )
		{
			echo "ServicoCliente->registarCliente(...): " . $e->getMessage();
			return "FAIL";
		}
	}

  public function consultarCliente(): string
  {
		try
		{
			$repositorioCliente = new RepoCliente();
			$repositorioCliente->carregarTodosCLientes();
			$repositorioCliente->encerrar();

			return "OK|" . array( "clientes" => json_encode($repositorioCliente->obterObjetos()) );
		}
		catch ( Throwable $e )
		{
			echo "ServicoCliente->consultarCLiente(...): " . $e->getMessage();
			return "FAIL";
		}
  }

	public function atualizarCliente(): string
	{
		return "";
	}

	/** Adiciona flag de removido:true no JSON */
	public function removerCliente(): string
	{
		return "";
	}

  public function  alterarMedidas(): string
	{
		return "";
	}

}

