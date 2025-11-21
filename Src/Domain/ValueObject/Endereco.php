<?php

namespace Src\Domain\Entity;

/* Classe interditada no momento. */
class Endereco
{
  private string  $pais;
  private ?string $unidadeAdministrativa;
  private string  $cidade;
  private string  $bairro;
  private string  $numeroImovel;
  private ?string $apartamento;

  public function __construct(
    string  $pais,
    ?string $unidadeAdministrativa,
    string  $cidade,
    string  $bairro,
    string  $numeroImovel,
    ?string $apartamento,
  )
  {
    $this->pais;
    $this->unidadeAdministrativa;
    $this->cidade;
    $this->bairro;
    $this->numeroImovel;
    $this->apartamento;
  }

  public function obterRepresentacaoCompleta(): object
  {
    return array(
      "pais" => $this->pais,
      "unidadeAdministrativa" => $this->unidadeAdministrativa,
      "cidade" => $this->cidade,
      "bairro" => $this->bairro,
      "numeroImovel" => $this->numeroImovel,
      "apartamento" => $this->apartamento
    );
  }

}
