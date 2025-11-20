<?php

namespace Src\Domain\Entity;

use Src\Domain\Service\ServicoCostureira;
use Src\Domain\ValueObject\Contato;
use Src\Domain\ValueObject\Medida;

class Cliente
{
  protected string $nome;

  /** @var ServicoCostureira[] */
  protected array $servicos = [];

  protected Contato $contato;
  protected Medida $medida;

  public function __construct( string $nome, array $servicos)
  {
    $this->nome;
  }

}
