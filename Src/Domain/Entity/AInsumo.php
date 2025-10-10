<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;

abstract class AInsumo
{
    private int $id;
    private string $nome;
    private IPreco $preco;

    public function __construct( int $id, string $nome, IPreco $preco )
    {
        $this->validarNome( $nome );

        $this->id = $id;
        $this->nome = $nome;
        $this->preco = $preco;
    }

    // Como se mede o insumo específico.
    abstract public function obterUnidadeMedida(): string;

    public function obterNome(): string
    {
        return $this->nome;
    }

    public function obterPreco(): float
    {
        return $this->preco->obterPreco();
    }

    // Muda conforme alteração de quantidade específica.
    abstract protected function computarPreco(): void;

    protected function validarNome( string $proposta ): void
    {
        if ( !$this->eNome( $proposta ) )
        {
            throw new Exception( get_class($this) . ": Insumo sem nome válido." );
        }
        return;
    }

    protected function eNome( string $proposta ): bool
    {
        if ( $proposta == "" )
        {
            return false;
        }
        return true;
    }

    protected function obterIdentificador(): int
    {
        return $this->id;
    }

}
