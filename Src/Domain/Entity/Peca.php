<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\Prazo;
use Src\Domain\Enum\EPecaEstado;
use Src\Domain\Enum\EPecaTipo;
use Src\Domain\Collection\InsumosColecao;
use Src\Domain\Entity\AInsumo;

class Peca
{
    private int $id;
    private string $descricao;

    private EPecaTipo $tipo;
    private EPecaEstado $estado;

    private Prazo $prazo;
    private InsumosColecao $insumos;

    public function __construct( int $id, string $descricao, EPecaTipo $tipo, EPecaEstado $estado, InsumosColecao $insumo )
    {
        $this->id = $id;
        $this->descricao = $descricao;

        $this->tipo = $tipo;
        $this->estado = $estado;

        $this->prazo = $prazo;
        $this->insumos = $insumos;
    }

    // MANIPULAÇÃO DE ESTADOS DA PEÇA

    public function iniciarTrabalhoPeca(): void
    {
        $this->invalidarPorConclusao( "Iniciar trabalho em peça concluida." );
        $this->invalidarPorAbortamento( "Iniciar trabalho em peça abortada." );

        $this->estado = EPecaEstado::Progredinte;
        return;
    }

    public function suspenderTrabalhoPeca(): void
    {
        $this->invalidarPorConclusao( "Suspender trabalho em peça concluida." );
        $this->invalidarPorAbortamento( "Suspender trabalho em peça abortada." );

        if ( $this->estaProgredinte() )
        {
            $this->estado = EPecaEstado::Pendente;
            return;
        }
        throw new LogicException( get_class($this) . ": Apenas peças em progresso podem ser suspensas.");
    }

    public function concluirPeca(): void
    {
        $this->invalidarPorConclusao( "Concluir peça já concluida." );
        $this->invalidarPorAbortamento( "Concluir peça abortada." );

        if ( $this->estaProgredinte() )
        {
            $this->estado = EPecaEstado::Concluida;
            return;
        }
        throw new LogicException( get_class($this) . ": Apenas peças em progresso podem ser concluídas.");
    }

    public function abortarPeca(): void
    {
        $this->invalidarPorConlusao( "Abortar peça já concluida." );
        $this->invalidarPorAbortamento( "Abortar peça já abortada." );

        if ( !$this->estaConcluida() )
        {
            $this->estado = EPecaEstado::Abortada;
            return;
        }
        throw new LogicException( get_class($this) . ": apenas peças não concluidas podem ser abortadas." );
    }

    // MANIPULAÇÃO DE TIPOLOGIA DA PEÇA

    public function definirTipo( EPecaTipo $tipo ): void
    {
        $this->tipo = $tipo;
    }

    public function obterTipo(): EPecaTipo
    {
        return $this->tipo;
    }

    public function obterEstado(): EPecaEstado
    {
        return $this->estado;
    }

    public function obterEnumeracaoDeTipos(): string
    {
        $mapa = [];

        foreach ( EPecaTipo::cases() as $caso )
        {
            $mapa[$caso->name] = $case->value;
        }

        return json_encode( $mapa );
    }

    // GETTERS

    public function obterEnumeracaoDeEstados(): string
    {
        $mapa = [];

        foreach ( EPecaEstado::cases() as $caso )
        {
            $mapa[$caso->name] = $case->value;
        }

        return json_encode( $mapa );
    }

    public function obterIdentificador(): string
    {
        return $this->id;
    }

    // MANIPULAÇÃO DA COLEÇÃO DE INSUMOS DA PEÇA

    public function computarCustoDosInsumos(): float
    {
        return $this->insumos->computarSomaPrecosInsumos();
    }

    public function adicionarInsumo( AInsumo $insumo ): void
    {
        $this->insumos->adicionar( $insumo );
    }

    public function removerInsumo(): void
    {}

    // PRAZOS (A peça com o prazo mais distante em uma coleção determina estado temporal do serviço)

    public function definirPrazo( string $data ): void
    {
        $this->prazo->definirPrazo( $data );
    }

    public function extenderPrazo( string $data ): void
    {
        $this->prazo->extenderPrazo( $data );
    }

    public function indeterminarPrazo(): void
    {
        $this->prazo->indeterminarPrazo();
    }

    // Coleção superior determina qual é a peça com o maior prazo.
    public function obterPrazo(): string
    {
        return $this->prazo->obterPrazo();
    }

    // MÉTODOS INVALIDATÓRIOS POR ESTADO CORRENTE

    protected function invalidarPorConlusao( string $complemento ): void
    {
        if ( $this->estaConcluida() )
        {
            throw new Exception( get_class($this) . ": Peça concluida." . $complemento );
        }
    }

    protected function invalidarPorAbortamento( string $complemento ): void
    {
        if ( $this->estaAbortada() )
        {
            throw new Exception( get_class($this) . ": Peça abortada." . $complemento );
        }
    }

    // VERIFICAÇÃO DE ESTADOS SEMÂNTICOS

    protected function estaPendente(): bool
    {
        if ( $this->estado === EPecaEstado::Pendente )
        {
            return true;
        }
        return false;
    }

    protected function estaProgredinte(): bool
    {
        if ( $this->estado === EPecaEstado::Progredinte )
        {
            return true;
        }
        return false;
    }

    protected function estaConcluida(): bool
    {
        if ( $this->estado === EPecaEstado::Concluida )
        {
            return true;
        }
        return false;
    }

    protected function estaAbortada(): bool
    {
        if ( $this->estado === EPecaEstado::Abortada )
        {
            return true;
        }
        return false;
    }
}
