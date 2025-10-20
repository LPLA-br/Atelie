<?php

namespace Src\Domain\ValueObject;

interface IPreco
{
    public function alterarPreco( float $proposta ): void;
    public function aumentarQuantidade( float $quantidade ): void;
    public function diminuirQuantidade( float $quantidade ): void;
    public function obterPreco(): float;
    public function obterQuantidade(): float;
    public function obterTotal(): float;
}
