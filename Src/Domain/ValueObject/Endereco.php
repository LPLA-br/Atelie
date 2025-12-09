<?php

namespace Src\Domain\Entity;

/* Classe interditada no momento. */
class Endereco
{
  private string  $pais;
  private ?string $unidadeAdministrativa;
  private string  $cidade;
  private string  $bairro;
  private string  $rua;
  private string  $numeroImovel;
  private ?string $apartamento;

  public function __construct(
    string  $pais,
    ?string $unidadeAdministrativa,
    string  $cidade,
    string  $bairro,
    string  $rua,
    string  $numeroImovel,
    ?string $apartamento,
  )
  {
    $this->pais = $pais;
    $this->cidade = $cidade;
    $this->bairro = $bairro;
    $this->rua = $rua;
    $this->numeroImovel = $numeroImovel;
    $this->apartamento = $numeroApartamento;
  }

  public function obterRepresentacaoCompleta(): object
  {
    return array(
      "pais" => $this->pais,
      "unidadeAdministrativa" => $this->unidadeAdministrativa,
      "cidade" => $this->cidade,
      "bairro" => $this->bairro,
      "rua" => $this->rua,
      "numeroImovel" => $this->numeroImovel,
      "apartamento" => $this->apartamento
    );
  }

}
