<?php

namespace Src\Domain\Entity;

use Src\Domain\ValueObject\IPreco;
use Src\Domain\Entity\AInsumo;

class InsumoQuadrado extends AInsumo
{
  private float $metrosQuadrados;

  public function __construct( int $id, string $nome, IPreco $preco, string $unidade, float $metrosQuadrados )
  {
    parent::__construct( $id, $nome, $preco, $unidade );

    this->validarAreaQuadrada( $metrosQuadrados );
    this->computarPreco();
  }

  //----------------------------------------------------------------------------

  protected function obterUnidadeMedida(): string
  {
    return $this->unidade;
  }

  protected function computarPreco(): void
  {
    this->preco->multiplicar( $metrosQuadrados );
  }

  protected function validarAreaQuadrada( float $proposta ): void
  {
    if ( $proposta <= 0.0 )
    {
      throw new \Exception( "Metro quadrado não pode ser negativo ou nulo." );
    }
    return;
  }
}

