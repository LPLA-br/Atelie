<?php

namespace Src\Domain\Collection;

use Src\Domain\Entity\Peca;
use Src\Domain\Enum\EPecaEstado;
use Src\Domain\Enum\EPecaTipo;

class PecasColecao
{

    protected array $pecas;

    public function __construct( array $pecas )
    {
        $this->pecas = $pecas;
    }

    public function adicionar( Peca $peca ): void
    {
        $this->ePeca( $objeto );
        array_push( $this->pecas, $peca );
    }

    public function buscarPecaPeloId( int $id ): Peca | NULL
    {
        for ( $i = 0; $i < sizeof($this->pecas); $i++ )
        {
            if ( $this->pecas[ $i ]->obterIdentificador() === $i )
            {
                return $this->pecas[ $i ];
            }
        }
        return NULL;
    }

    public function buscarPeloEstado( EPecaEstado $estado, ?array $pecas ): Peca | array | NULL
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        $pecasEncontradas = [];

        if ( $pecas === NULL )
        {
            for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
            {
                if( $this->pecas[ $i ]->obterEstado() === $estado )
                {
                   array_push( $pecasEncontradas, $this->pecas[ $i ] );
                }
            }
            return $pecasEncontradas;
        }

        for ( $i = 0; $i < sizeof( $pecas ); $i++ )
        {
            if( $pecas[ $i ]->obterEstado() === $estado )
            {
               array_push( $pecasEncontradas, $pecas[ $i ] );
            }
        }

        return $pecasEncontradas;
    }

    public function buscarPeloTipo( EPecaTipo $tipo, ?array $pecas ): Peca | array | NULL
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        $pecasEncontradas = [];

        if ( $pecas === NULL )
        {
            for ( $i = 0; $i < sizeof( $pecas ); $i++ )
            {
                if( $pecas[ $i ]->obterTipo() === $tipo )
                {
                   array_push( $pecasEncontradas, $pecas[ $i ] );
                }
            }
        }

        for ( $i = 0; $i < sizeof( $pecas ); $i++ )
        {
            if( $pecas[ $i ]->obterTipo() === $tipo )
            {
               array_push( $pecasEncontradas, $pecas[ $i ] );
            }
        }

        return $pecasEncontradas;
    }

    public function remover( int $id ): void
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
        {
            if ( $this->pecas->obterIdentificador() === $id  )
            {
                array_splice( $this->pecas, $i, $i );
                break;
            }
        }
        return;
    }

    public function substituir( int $id, Peca $objeto ): void
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
        {
            if ( $this->pecas[ $i ]->obterIdentificador() === $id  )
            {
                $this->pecas[ $i ] = $objeto;
                break;
            }
        }
        return;
    }

    public function computarCusto(): int
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        $custo = 0.0;

        for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
        {
            $custo += $this->pecas[ $i ]->computarCustoDosInsumos();
        }

        return $custo;
    }

    // TODO: concluir implementação
    public function obterPecaMaiorPrazo(): string
    {
        $this->invalidarPorQuantidadeNulaDePecas();

        $maior = $this->pecas;

        for( $i = 0; $i < $this->pecas; $i++ )
        {
            $peca->obterPrazo();
        }
    }

    //--------------------------------

    private function invalidarPorQuantidadeNulaDePecas(): void
    {
        if ( !$this->semPecas )
        {
            throw new Exception( get_class($this) . ": não há pecas para computar custo." );
        }
    }

    private function ePeca( $objetoProposto ): void
    {
        if ( $objetoProposto instanceof Peca )
        {
            return;
        }
        throw new LogicException( get_class($this) . ": Não peca não adicionada a coleção." );
    }

    private function semPecas(): bool
    {
        if ( sizeof($this->pecas) == 0 )
        {
            return true;
        }
        return false;
    }
}
