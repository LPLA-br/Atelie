<?php

namespace Src\Domain\ValueObject;

interface IPreco
{
    public function definirNovoPreco( float $proposta ): void;
    public function zerarPreco(): void;
    public function multiplicar( int $quantidade ): void;
    public function subtrair( int $quantidade ): void;
    public function obterPreco(): float;
}
