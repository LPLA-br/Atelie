<?php

namespace Src\Domain\Service;

use Src\Domain\Repository\RepoCliente;
use Src\Domain\Entity\Cliente;

use Src\Domain\Repository\IRepositorio;
use Src\Domain\Repository\RepositorioAdapter;

/* Use cases para manipulação informacional de clientes
 *
 * Recebe: Sujeito|Verbo|Objeto, Cliente, IRepositorioAdapter
 * Retorna: struct Resposta stringficada do serviço cliente
 * Modo de vida: construção->ação->destruição
 * */
class ServicoCliente
{

	private object $svo;
	private Cliente $cliente;
	private IRepositorio $repo;

  public function __construct( object $svo )
  {
		$this->svo = $svo;
		$this->repo = new RepositorioAdapter();
  }

	// MÉTODOS

	public function registarCliente(): string
	{
		try
		{
			$cliente = new Cliente(
				-1,
				$svo->objeto->nome,
				( $svo->objeto->contato ? $svo->objeto->contato : NULL ),
				( $svo->objeto->medidas ? $svo->objeto->medidas : NULL ),
				( $svo->objeto->endereco ? $svo->objeto->endereco : NULL ),
			);

			$repositorioCliente = new RepoCliente( $this->repo );
			$repositorioCliente->registrarNovoCliente( $cliente );
			$repositorioCliente->encerrar();

			return '{"status":"OK"}';
		}
		catch ( Throwable $e )
		{
			echo "ServicoCliente->registarCliente(...): " . $e->getMessage();
			return '{"status":"FAIL"}';
		}
	}

  public function consultarTodosClientes(): string
  {
		try
		{
			$repositorioCliente = new RepoCliente( $this->repo );
			$repositorioCliente->carregarTodosClientes();
			$dados = $repositorioCliente->obterObjetos();
			$representacoes = array();

			foreach ($dados as $objetoComAtributosPrivadosProtegidos ) {
				array_push( $representacoes , $objetoComAtributosPrivadosProtegidos->obterRepresentacaoJSON() );
			}
	
			$retorno = json_encode(array(
				"status" => "OK",
				"clientes" => json_encode( $representacoes )
			));

			$repositorioCliente->encerrar();

			return $retorno;
		}
		catch ( Throwable $e )
		{
			echo "ServicoCliente->consultarCLiente(...): " . $e->getMessage();
			return '{"status":"FAIL"}';
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

