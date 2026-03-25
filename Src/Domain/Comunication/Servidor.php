<?php

namespace Src\Domain\Comunication;

use Src\Domain\Comunication\IServidor;
use Src\Domain\Service\ServicoCliente;

/** Implementação do protocolo atelie
 *  baseado em csv e json e de estilo
 *  remote procedure call.
 *  Classe de vida longa não paralelizada.
 *  cliente|criar|{"nome":"Maria","medida":{"cintura":70cm}}\n
 * */
class Servidor implements IServidor
{
  private string $inet4;
  private int $porta;

  private $socket;
  private $bytesize;

  private string $comando;

	/** Representa requisição do protocolo ateliê
	 *	@property string $sujeito		Entidade passiva.
	 *	@property string $verbo			Ação a ser realizada.
	 *	@property string$objeto			Dados JSON stringficados para ação a ser realizada.
	 * */
  private object $comando_objeto;

  const SEPARADORES = "|";

  public function __construct( string $inet4, int $porta )
  {
    $this->inet4 = $inet4;
    $this->porta = $porta;
    $this->bytesize = 2048;
    $this->comando_objeto = (object) array();

    $this->socket = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
    if(!$this->socket)
    {
      $this->checkSocket( "Não foi possivel criar socket UDP do servidor" );
    }
    if( socket_bind( $this->socket, $this->inet4, $this->porta ) === false )
    {
      $this->checkSocket( "Não foi possivel atribuir porta e interface de rede" );
    }
    fwrite( STDOUT, "socket criado !" );

    $this->comando = '';
  }

  public function obterObjetoComando(): object
  {
    return $this->comando_objeto;
  }

  //-----------------------------------------

  public function ouvir(): void
  {
    while (1)
    {
      $this->limparBufferTextualComando();

      $ip_cliente = '';
      $porta_cliente = '';

      if( socket_recvfrom( $this->socket, $this->comando, $this->bytesize, 0, $ip_cliente, $porta_cliente ) === FALSE )
      {
        $codigo_erro = socket_last_error();
        $mensagem_erro = socket_strerror($codigo_erro);
        socket_close( $this->socket );
        die( "Não foi possível receber dados: [$codigo_erro] $mensagem_erro" );
      }
      $this->analizarComandoCorrente();
      $this->eliminarSeparadores();
      //$this->responderEco( $ip_cliente, $porta_cliente );
			$this->rotearPorSujeito( $ip_cliente, $porta_cliente );
      fwrite( STDOUT, $this->comando );
      var_dump( $this->comando_objeto );
			$this->limparBufferTextualComando();
    }
  }

  public function fechar(): void
  {
    socket_close( $this->socket );
  }


  //------------------------------------------------

  protected function rotearPorSujeito( string $ip_cliente, string $porta_cliente ): void
	{
		$sujeito = $this->comando_objeto->sujeito;

		switch( $sujeito )
		{
			case "cliente":
				$this->direcionarVerboDoCliente( $ip_cliente, $porta_cliente );
				break;
			case "servicoCostureira":
				//$this->direcionarParaVerbo();
				$this->responder( $ip_cliente, $porta_cliente, '{desc:"não implementado"}' );
				break;
			default:
				fwrite( STDOUT, ("Sujeito inválido: " . $sujeito . "\n") );
				break;
		}
	}

	/** Método subordinado a rotearPorSujeito(...) */
	protected function direcionarVerboDoCliente( string $ip_cliente, string $porta_cliente ): void
	{
		try
		{
			$verbo  = $this->comando_objeto->verbo;
			$objeto = $this->comando_objeto->objeto;

			switch( $verbo )
			{
				case "criar":
					$servicoCliente = new ServicoCliente( json_decode($objeto) );
					$this->responder( $ip_cliente, $porta_cliente, $servicoCliente->registarCliente() );
					break;
				case "ler":
					$servicoCliente = new ServicoCliente( json_decode($objeto) );
					$this->responder( $ip_cliente, $porta_cliente, $servicoCliente->consultarTodosClientes() );
					break;
				case "atualizar":
					break;
				case "remover":
					break;
				default:
					fwrite( STDOUT, ("Servidor ServicoCliente ERR:verbo inválido " . $verbo . "\n") );
					break;
			}
		}
		catch ( Throwable $e )
		{
			echo "Servidor ServicoCliente: " . $e->getMessage();
			return;
		}
	}

	protected function direcionarParaVerboDeServicoCostureira(): void
	{}

	protected function responder( string $ip_cliente, string $porta_cliente, string $stringDadosJSON ): void
  {
    socket_sendto( $this->socket, $stringDadosJSON, strlen($stringDadosJSON), 0, $ip_cliente, $porta_cliente );
  }

  //testes
  protected function responderEco( string $ip_cliente, string $porta_cliente ): void
  {
    socket_sendto( $this->socket, $this->comando, strlen($this->comando), 0, $ip_cliente, $porta_cliente );
  }

  private function checkSocket( string $mensagem )
  {
    $err = socket_last_error();
    $msg = socket_strerror( $err );
    die( "Erro crítico: ".$mensagem." [".$err."] ".$msg );
  }

	/* Interpreta comando enviado via socket UDP
	 * 
	 * */
  private function analizarComandoCorrente(): void
  {
    $str = $this->comando;
    $svo = ['','',''];
    $leitorPosicao = 0;
    $posicaoSubstrigEscrita = 0;

    for ( $i = 0; $i < strlen($str); $i++ )
    {
      //transcrição
      $svo[$leitorPosicao][$posicaoSubstrigEscrita] = $str[$i];
      $posicaoSubstrigEscrita++;

      if ( $str[$i] === self::SEPARADORES )
      {
        $leitorPosicao++;
        $posicaoSubstrigEscrita = 0;
      }

      if ( $str[$i] == "\n" || $str[$i] == '\n' )
      {
        break;
      }
    }
    
    $this->comando_objeto = (object) array(
      "sujeito" => $svo[0],
      "verbo"   => $svo[1],
      "objeto"  => $svo[2]
    );
  }

  private function limparBufferTextualComando(): void
  {
    $this->comando = '';
  }

  private function eliminarSeparadores(): void
  {
    $this->comando_objeto->sujeito = str_replace(['|'], '', $this->comando_objeto->sujeito);
    $this->comando_objeto->verbo = str_replace(['|'], '', $this->comando_objeto->verbo);
    $this->comando_objeto->objeto = str_replace(['|'], '', $this->comando_objeto->objeto);
  }

  private function obterParteObjetoComoJson(): object
  {
    try
    {
      return json_decode( $this->comando_objeto->objeto );
    }
    catch ( \Exception $e )
    {
      fwrite( STDERR, $e->getMessage() );
      return (object) array();
    }
  }

}

