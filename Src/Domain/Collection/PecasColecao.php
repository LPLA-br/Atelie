<?php

namespace Src\Domain\Collection;

use Src\Domain\Collection\ACollection;

use Src\Domain\Entity\Peca;
use Src\Domain\Enum\EPecaEstado;
use Src\Domain\Enum\EPecaTipo;

class PecasColecao extends ACollection
{

  public function __construct( array $pecas )
  {
    parent::__construct( $pecas, "Peca" );
  }

  public function adicionar( Peca $peca ): void
  {
    $this->validarIdNovaPeca( $peca );
    array_push( $this->lista, $peca );
  }

  public function buscarPeloEstado( EPecaEstado $estado ): Peca | array | NULL
  {
    return $this->buscarLinearmentePeloEstado( $estado );
  }

  public function buscarPeloTipo( EPecaTipo $tipo ): Peca | array | NULL
  {
    return $this->buscarLinearmentePeloTipo( $tipo );
  }

  //--------------------------------

  public function computarCustoTotal(): float
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $custo = 0.0;

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      $custo += $this->lista[ $i ]->obterCustoTodosInsumos();
    }
    return $custo;
  }

  //-------------------------------

  public function obterPrazoDaPecaMaiorPrazo(): string
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $maiorPrazoAtual = $this->lista[0]->obterPrazo();

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      $prazoEmAnalise = $this->lista[ $i ]->obterPrazo();
      if ( $maiorPrazoAtual < $prazoEmAnalise )
      {
        $maiorPrazoAtual = $prazoEmAnalise;
        continue;
      }
    }
    return $maiorPrazoAtual;
  }

  public function obterPecasPendentes(): Peca | array | NULL
  {
    return $this->buscarLinearmentePeloEstado( EPecaEstado::Pendente );
  }

  public function obterQuantidadePecasPendentes(): int
  {
    return sizeof($this->buscarLinearmentePeloEstado( EPecaEstado::Pendente ));
  }

  public function obterPecasConcluidas(): Peca | array | NULL
  {
    return $this->buscarLinearmentePeloEstado( EPecaEstado::Concluida );
  }

  public function obterQuantidadePecasConcluidas(): int
  {
    return sizeof($this->buscarLinearmentePeloEstado( EPecaEstado::Concluida ));
  }

  public function obterPecasProgredintes(): Peca | array | NULL
  {
    return $this->buscarLinearmentePeloEstado( EPecaEstado::Progredinte );
  }

  public function obterQuantidadePecasProgredintes(): int
  {
    return sizeof($this->buscarLinearmentePeloEstado( EPecaEstado::Progredinte ));
  }

  //--------------------------------
  // BUSCA ESPECÍFICA

  private function buscarLinearmentePeloEstado( EPecaEstado $estado ): Peca | array | NULL
  {
    $pecasEncontradas = [];

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      if ( $this->lista[ $i ]->obterEstado() === $estado )
      {
        array_push( $pecasEncontradas, $this->lista[ $i ] );
      }
    }

    if ( sizeof( $pecasEncontradas ) === 0 ) return NULL;
    else if ( sizeof( $pecasEncontradas ) === 1 ) return $pecasEncontradas[0];
    return $pecasEncontradas;
  }

  private function buscarLinearmentePeloTipo( EPecaTipo $tipo ): Peca | array | NULL
  {
    $pecasEncontradas = [];

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      if( $this->lista[ $i ]->obterTipo() === $tipo )
      {
        array_push( $pecasEncontradas, $this->lista[ $i ] );
      }
    }

    if ( sizeof( $pecasEncontradas ) === 0 ) return NULL;
    else if ( sizeof( $pecasEncontradas ) === 1 ) return $pecasEncontradas[0];
    return $pecasEncontradas;
  }

}
