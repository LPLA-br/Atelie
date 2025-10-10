<?php

namespace Src\Domain\Collection;

use Src\Domain\Entity\AInsumo;

class InsumosColecao
{

    /* AInsumo */
    private array $insumos;
    private float $custo;

    public function __construct( array $insumos )
    {
        $this->insumos = $insumos;
        $this->custo = $this->computarSomaPrecosInsumos();
    }

    public function adicionar( AInsumo $objeto ): void
    {
        array_push( $this->insumos, $objeto );
    }

    public function buscarPorIdentificador( int $id ): AInsumo | NULL
    {
        for ( $i=0; $i<sizeof($this->insumos); $i++ )
        {
            if ( $this->insumos[$i]->obterIdentificador() === $id )
            {
                return $this->insumos[$i];
            }
        }
        return NULL;
    }

    public function buscarPorNome( string $nome ): AInsumo | NULL
    {
        $this->validarStringBusca( $nome );
        for ( $i=0; $i<sizeof($this->insumos); $i++ )
        {
            if ( $this->insumos[$i]->obterNome() == $nome )
            {
                return $this->insumos[$i];
            }
        }
        return NULL;
    }

    public function remover( string $nome ): void
    {
        $index = $this->buscarIndexDeObjetoPeloNome( $nome );
        if ( !$index === -1 )
        {
            array_splice( $this->insumos[ $index ] );
        }
        return;
    }

    public function substituir( string $nome, AInsumo $objeto ): void
    {
        $anterior = this->buscarIndexDeObjetoPeloNome( $nome );
        if ( !$anterior === -1 )
        {
            $this->insumos[ $anterior ] = $objeto;
        }
        return;
    }

    public function computarSomaPrecosInsumos(): float
    {
        $custo = 0.0;

        if ( sizeof( $this->insumos ) > 0 )
        {
            for ( $i=0; $i<sizeof($this->insumos); $i++ )
            {
                $custo += $this->insumos[$i]->obterPreco();
            }
        }

        return $custo;
    }

    protected function validarStringBusca( string $proposta ): void
    {
        if ( !is_string( $nome ) && !strlen($proposta) > 0 )
        {
            throw new Exception( get_class($this) . ": String de busca inválida." );
        }
        return;
    }

    protected function buscarIndexDeObjetoPeloNome( string $nome ): int
    {
        $this->validarStringBusca( $nome );

        for ( $i=0; $i<sizeof($this->insumos); $i++ )
        {
            if ( $this->insumos[$i]->obterNome() == $nome )
            {
                return $i;
            }
        }
        return -1;
    }

}
