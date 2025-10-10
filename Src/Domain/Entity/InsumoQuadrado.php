<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\AInsumo;

class InsumoQuadrado extends AInsumo
{
    private float $metrosQuadrados;

    public function __construct( int $id, string $nome, IPreco $preco, float $metrosQuadrados )
    {
        parent::__construct( $id, $nome, $preco );

        this->validarAreaQuadrada( $metrosQuadrados );
        this->computarPreco();
    }

    protected function computarPreco(): void
    {
        this->preco->multiplicar( $metrosQuadrados );
    }

    protected function validarAreaQuadrada( float $proposta ): void
    {
        if ( $proposta <= 0.0 )
        {
            throw new LogicException( get_class($this) . ": Metro quadrado não pode ser negativo ou nulo" );
        }
        return;
    }
}

