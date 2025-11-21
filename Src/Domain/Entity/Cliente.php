<?php

namespace Src\Domain\Entity;

use Src\Domain\Service\ServicoCostureira;
use Src\Domain\ValueObject\Contato;
use Src\Domain\ValueObject\Medida;

class Cliente
{
  protected int $id;
  protected string $nome;

  // TIPO | NULL
  protected ?Contato $contato;
  protected ?Medida $medida;
  protected ?Endereco $endereco;

  public function __construct(
    int $id,
    string $nome,
    array $servicos,
    ?Contato $contato,
    ?Medida $medida,
    ?Endereco $endereco
  )
  {
    $this->id;
    $this->nome;
    $this->contato = NULL;
    $this->medida = NULL;
    $this->endereco = NULL;

    switch ( true )
    {
      case ($contato !== NULL):
        $this->contato = $contato;
      case ($medida !== NULL):
        $this->medida = $medida;
      case ($endereco !== NULL):
        $this->endereco = $endereco;
    }
  }

  //-----------------------------------

  public function obterId(): int
  {
    return $this->id;
  }

  public function obterNome(): string
  {
    return $this->nome;
  }

  public function obterContato(): object
  {
    $this->validarOperacaoAgregada( $this->contato, "Contato" );
    return $this->contato->obterRepresentacaoCompleta();
  }

  public function obterMedidas(): object
  {
    $this->validarOperacaoAgregada( $this->medida, "Medida" );
    return $this->medida->obterTodasMedidas();
  }

  public function obterEndereco(): object
  {
    $this->validarOperacaoAgregada( $this->endereco, "Endereco" );
    return "";
  }

  //-----------------------------------

  protected function validarOperacaoAgregada( object | NULL $objeto, string $nomeObjetoAgregado ): void
  {
    if ( $objeto === NULL )
    {
      throw new \Exception( "Ação indisponível pois " . $nomeObjetoAgregado . " não agregado." );
    }
  }

}
