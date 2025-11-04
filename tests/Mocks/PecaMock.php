<?php

namespace Src\Domain\Collection;

class Peca
{
  private int $id;
  private string $descricao;

  private EPecaTipo $tipo;
  private EPecaEstado $estado;

  private Prazo $prazo;
  private InsumosColecao $insumos;

  public function __construct(
    int $id,
    string $descricao, 
    EPecaTipo $tipo,
    EPecaEstado $estado,
    Prazo $prazo,
    InsumosColecao $insumo )
  {
    $this->id = $id;
    $this->descricao = $descricao;

    $this->tipo = $tipo;
    $this->estado = $estado;

    $this->prazo = $prazo;
    $this->insumos = $insumo;
  }

  public function obterId(): int
  {
    return $this->id;
  }

  public function obterDescricao(): string
  {
    return $this->descricao;
  }

  public function obterTipo(): EPecaTipo
  {
    return $this->tipo;
  }

  public function obterEstado(): EPecaEstado
  {
    return $this->estado;
  }
}

