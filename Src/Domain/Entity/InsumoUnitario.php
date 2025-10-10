<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\AInsumo;

class InsumoUnitario extends AInsumo
{
    private int $quantidade;
    private float $custoUnitario;

    public function __construct( int $id, string $nome, IPreco $preco ,int $quantidade, float $custoUnitario )
    {
        parent::__construct( $id, $nome, $preco );

        $this->validarQuantidade( $quantidade );

        $this->quantidade = $quantidade;
        $this->custoUnitario = $custoUnitario;

        $this->computarPreco();
    }

    private function computarPreco(): void
    {
        this->preco->multiplicar( this->quantidade );
    }

    protected function validarQuantidade( int $quantidade ): void
    {
        if ( $quantidade <= 0 )
        {
            throw new LogicException( get_class($this) . ": Insumo não pode ter quantidade negativa ou nula." );
        }
        return;
    }

    protected function validarCustoUnitario( float $custoUnitario ): void
    {
        if ( $custoUnitario <= 0.0 )
        {
            throw new LogicException( get_class($this) . ": Custo de unidade não pode ser negativo ou nulo" );
        }
        return;
    }

}
