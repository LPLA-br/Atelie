<?php

namespace Src\Domain\Collection;

use Src\Domain\Entity\ITemObterId;
use Src\Domain\Entity\AInsumo;

/* Métodos fundamentais de toda coleção de AInsumos
 * Classe experimental
 * */
abstract class ACollection
{
  protected array $lista;

  public function __construct( array $colecao, string $className )
  {
    $this->validarTiposElementos( $colecao, $className );
    $this->validarNumeroMinimoElementos( $colecao );
    $this->validarUnicidadeDeIds( $colecao );

    $this->lista = $colecao;
  }

  //----------------------------
  // MÉTODOS PUBLICOS

  public function buscarPorId( int $id ): ITemObterId | NULL
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    return $this->buscarLinearmentePorId( $id );
  }

  public function removerPorId( int $id ): ITemObterId | NULL
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $indicie = $this->buscarLinearmenteIndicieElementoPeloId( $id );

    if ( !($id !== -1) )
    {
      throw new \Exception( "elemento " . $id . " da coleção inexistente. Remoção abortada" );
    }

    return array_splice( $this->lista, $indicie, 1 )[0];
  }

  /** retorna nova representação*/
  public function substituirPorId( int $id, ITemObterId $proposta ): ITemObterId | NULL
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $this->validarTipoElemento( $proposta, "\Src\Domain\Entity\AInsumo" );

    $indicie = $this->buscarLinearmenteIndicieElementoPeloId( $id );

    if ( $indicie === -1 )
    {
      throw new \Exception( "elemento " . $id . " da coleção inexistente. Substituição abortada !" );
      return NULL;
    }

    $this->lista[ $indicie ] = $proposta;
    return $this->lista[ $indicie ];
  }

  //----------------------------
  // GETTERS

  public function obterColecao(): array
  {
    return $this->lista;
  }

  public function obterNumeroElementos(): int
  {
    return sizeof( $this->lista );
  }

  //----------------------------
  // ALGORITMOS DE BUSCA

  protected function buscarLinearmentePorId( int $id ): ITemObterId | NULL
  {
    $this->validarNumeroMinimoElementos( $this->lista );

    for ( $i = 0; $i < sizeof($this->lista); $i++ )
    {
      if ( $this->lista[ $i ]->obterId() === $id )
      {
        return $this->lista[ $i ];
      }
    }
    return NULL;
  }
  
  protected function buscarLinearmenteIndicieElementoPeloId( int $id ): int
  {
    $this->validarNumeroMinimoElementos( $this->lista );

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      if( $this->lista[ $i ]->obterId() === $id )
      {
        return $i;
      }
    }
    return -1;
  }

  //----------------------------
  // ALGORITMOS DE ORDENAÇÃO

  //----------------------------
  // FORMA ESPECIFICA DE EMITIR PROBLEMAS NAS COLEÇÕES

  protected function validarTipoElemento( ITemObterId $objeto, string $className ): void
  {
    if ( !$this->eTipoCorreto( $objeto, $className ) )
    {
      throw new \Exception( "elemento de tipo " . gettype( $objeto ) ." não é instância de " . $className );
    }
  }

  protected function validarTiposElementos( array $objetos, string $className ): void
  {
    if ( !$this->saoTodosTipoCorreto( $objetos, $className ) )
    {
      throw new \Exception( "objetos possuem elemento(s) do tipo não " . $className );
    }
  }

  protected function validarTipoNovoElemento( ITemObterId $objeto, string $className ): void
  {
    if ( !$this->eTipoCorreto( $objeto, $className ) )
    {
      throw new \Exception( "novoElemento não é do tipo " . $className );
    }
  }

  //construtor
  protected function validarUnicidadeDeIds( array $objetos ): void
  {
    if ( !$this->saoTodosIdsDiferentes( $objetos ) )
    {
      throw new \Exception( "objetos possuem elementos com id's iguais " . $objetos );
    }
  }

  protected function validarUnicidadeDeIdsParaNovoElemento( ITemObterId $novoElemento ): void
  {
    if ( !($this->possuiElementoIdDiferenteParaColecao( $novoElemento )) )
    {
      throw new \Exception( "novoElemento de id " . $novoElemento->obterId() . " conflita com id de elemento pre existente." );
    }
  }

  protected function validarNumeroMinimoElementos( array $objetos ): void
  {
    if ( !( sizeof($objetos) > 0 ) )
    {
      throw new \Exception( "Coleção possui nenhum elemento." );
    }
  }

  //-----------------------------

  protected function eTipoCorreto( ITemObterId $objeto, string $className ): bool
  {
    return ( $objeto instanceof $className );
  }

  protected function saoTodosTipoCorreto( array $objetos, string $className ): bool
  {
    for ( $i = 0; $i < sizeof( $objetos ); $i++ )
    {
      if ( $this->eTipoCorreto( $objetos[ $i ], $className ) )
      {
        return false;
      }
    }
    return true;
  }

  /*Varredura em duas dimensões */
  private function saoTodosIdsDiferentes( array $objetos ): bool
  {
    for ( $i = 0; $i < (sizeof($objetos)); $i++ )
    {
      for ( $j = 0; $j < (sizeof($objetos)); $j++ )
      {
        if ( $i === $j ) continue;

        if ( $objetos[ $i ]->obterId() === $objetos[ $j ]->obterId() )
        {
          return false;
        }
      }
    }
    return true;
  }

  private function possuiElementoIdDiferenteParaColecao( ITemObterId $objeto ): bool
  {
    for ( $i = 0; $i < (sizeof($this->lista)); $i++ )
    {
      if ( $this->lista[ $i ]->obterId() === $objeto->obterId() )
      {
        return false;
      }
    }
    return true;
  }


}

