<?php

namespace Src\Domain\Entity;

use Src\Domain\Entity\Cliente;
use Src\Domain\Entity\Peca;
use Src\Domain\Service\ServicoCostureira;

class Cliente
{
    protected string $nome;

    /** @var ServicoCostureira[] */
    protected array $servicos = [];

    public function __construct( string $nome )
    {
        $this->nome;
    }

}
