<?php

namespace Src\Domain\Collection;

use Src\Domain\Entity\Peca;
use Src\Domain\Enum\EPecaEstado;
use Src\Domain\Enum\EPecaTipo;

class PecasColecao
{

  private array $pecas;

  public function __construct( array $pecas )
  {
    $this->validarPecas( $pecas );
    $this->validarQuantidadePecas( $pecas );
    $this->validarUnicidadeDeIds( $pecas );

    $this->pecas = $pecas;
  }

  public function adicionar( Peca $peca ): void
  {
    $this->validarPeca( $peca );
    $this->validarIdNovaPeca( $peca );
    array_push( $this->pecas, $peca );
  }

  public function buscarPecaPeloId( int $id ): Peca | NULL
  {
    return $this->buscarPecaPeloId( $id );
  }

  public function buscarPeloEstado( EPecaEstado $estado ): Peca | array | NULL
  {
    return $this->buscarPeloEstado( $estado );
  }

  public function buscarPeloTipo( EPecaTipo $tipo ): Peca | array | NULL
  {
    return $this->buscarPeloTipo( $tipo );
  }

  public function removerPorId( int $id ): Peca | NULL
  {
    $this->validarQuantidadePecas( $this->pecas );
    $indicie = $this->buscarIndiciePecaPeloId( $id );

    if ( $indicie !== -1 )
    {
      return array_splice( $this->insumos, $indicie, 1 )[0];
    }
    throw new \Exception( "elemento com id \"" . $id . "\" para ser removido não existe." );
  }

  public function substituir( int $id, Peca $proposta ): void
  {
    $indicie = $this->buscarIndiciePecaPeloId( $id );

    if ( $indicie !== -1 )
    {
      $this->validarIdNovaPeca( $proposta );
      $this->pecas[ $indicie ] = $proposta;
    }
  }

  public function computarCustoTotal(): int
  {
    $this->validarQuantidadePecas( $this->pecas );
    $custo = 0.0;

    for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
    {
      $custo += $this->pecas[ $i ]->obterCustoTodosInsumos();
    }
    return $custo;
  }

  // TODO: concluir implementação
  public function obterPecaMaiorPrazo(): string
  {
    $this->validarQuantidadePecas( $this->pecas );

    $maior = $this->pecas[0];

    for( $i = 0; $i < $this->pecas; $i++ )
    {
      $peca->obterPrazo();
    }
  }

  //--------------------------------

    //algoritmos de busca linear utilitária

  private function buscarPeloId( int $id ): Peca | NULL
  {
    for ( $i = 0; $i < sizeof($this->pecas); $i++ )
    {
      if ( $this->pecas[ $i ]->obterId() === $i )
      {
        return $this->pecas[ $i ];
      }
    }
    return NULL;
  }

  private function buscarPeloEstado( EPecaEstado $estado ): Peca | array | NULL
  {
    $pecasEncontradas = [];

    for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
    {
      if ( $this->pecas[ $i ]->obterEstado() === $estado )
      {
        array_push( $pecasEncontradas, $this->pecas[ $i ] );
      }
    }
    return $pecasEncontradas;
  }

  private function buscarPeloTipo( EPecaTipo $tipo ): Peca | array | NULL
  {
    $pecasEncontradas = [];

    for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
    {
      if( $this->pecas[ $i ]->obterTipo() === $tipo )
      {
        array_push( $pecasEncontradas, $this->pecas[ $i ] );
      }
    }

    return $pecasEncontradas;
  }

  private function buscarIndiciePecaPeloId( $id ): int
  {
    for ( $i = 0; $i < sizeof( $this->pecas ); $i++ )
    {
      if( $this->pecas[ $i ]->obterId() === $id )
      {
        return $i;
      }
    }
  }

  //--------------------------------

  private function validarPecas( $arrayObjetos ): void
  {
    if ( !$this->saoTodasPecas( $arrayObjetos ) === true )
    {
      throw new \Exception( "Array possui elemento não Peca." );
    }
    return;
  }

  private function validarPeca( $peca ): void
  {
    if ( !$this->ePeca( $peca ) )
    {
      throw new \Exception( "Objeto não peça detectado." );
    }
  }

  private function validarQuantidadePecas( $arrayObjetos ): void
  {
    if ( !(sizeof( $arrayObjetos ) > 0) )
    {
      throw new \Exception( "Array passado possui praticamente nenhum objeto." );
    }
  }

  /*transcrito de InsumosColecao -> herança abstrata (construção)*/
  private function validarUnicidadeDeIds( $arrayObjetos ): void
  {
    if ( !$this->saoTodosIdsDiferentes( $arrayObjetos ) )
    {
      throw new \Exception( "Array de objetos possui conflito de identificadores." );
    }
  }

  // antes da inserção de nova Peca
  private function validarIdNovaPeca( Peca $proposta ): void
  {
    if ( !$this->eIdDiferenteNaColecao( $proposta->obterId() ) )
    {
      throw new \Exception( "Identificador já existe na coleção." );
    }
  }

  //--------------------------------

  private function eIdDiferenteNaColecao( int $id ): bool
  {
    for ( $i = 0; $i < (sizeof($this->pecas)); $i++ )
    {
      if ( $this->pecas[ $i ]->obterId() === $id )
      {
        return false;
      }
    }
    return true;
  }

  private function ePeca( $objetoProposto ): bool
  {
    if ( $objetoProposto instanceof Peca )
    {
      return true;
    }
    return false;
  }

  private function saoTodasPecas( $arrayObjetos ): bool
  {
    for( $i = 0; $i <= sizeof( $this->pecas ); $i++ )
    {
      if ( !$this->ePeca( $arrayObjetos[ $i ] ) )
      {
        return false;
      }
    }
    return true;
  }

  /*transcrito de InsumosColecao -> herança abstrata*/
  private function saoTodosIdsDiferentes( $arrayObjetos ): bool
  {
    for ( $i = 0; $i < (sizeof($arrayObjetos)); $i++ )
    {
      for ( $j = 0; $j < (sizeof($arrayObjetos)); $j++ )
      {
        if ( $i === $j ) continue;

        if ( $arrayObjetos[ $i ] === $arrayObjetos[ $j ] )
        {
          return false;
        }
      }
    }
    return true;
  }
}
