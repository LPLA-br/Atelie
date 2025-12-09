<?php

namespace Src\Domain\Repository;

/** Métodos contratuais abstratos do adaptador SGBD */
interface IRepositorio
{
  public function ler( string $consulta ): void;
  public function escrever( string $ordem, array $dados ): void;
  public function redefinir(): void;
  public function encerrar(): void;
}

