<?php

namespace Src\Domain\Collection;

use Src\Domain\Entity\AInsumo;
use Src\Domain\Entity\InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado;

/** Representa coleção de objetos
 *  onde cada objeto representa N insumos
 *  de uma determinada caracteristica.
 *  */
class InsumosColecao
{

  private array $insumos;
  private float $custo;

  public function __construct( array $insumos )
  {
    $this->validarTiposObjetos( $insumos );
    $this->validarUnicidadeDeNomes( $insumos );

    $this->insumos = $insumos;
    $this->custo = $this->computarSomaPrecosInsumos();
  }

  public function adicionar( AInsumo $objeto ): void
  {
    array_push( $this->insumos, $objeto );
  }

  public function buscarPorId( int $id ): AInsumo | NULL
  {
    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[ $i ]->obterId() === $id )
      {
        return $this->insumos[$i];
      }
    }
    return NULL;
  }

  public function buscarPorNome( string $nome ): AInsumo | NULL
  {
    $this->validarStringBusca( $nome );

    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[$i]->obterNome() === $nome )
      {
        return $this->insumos[$i];
      }
    }
    return NULL;
  }

  public function remover( string $nome ): void
  {
    $index = $this->buscarIndexDeObjetoPeloNome( $nome );
    if ( !$index === -1 )
    {
      array_splice( $this->insumos[ $index ] );
    }
    return;
  }

  public function substituir( string $nome, AInsumo $objeto ): void
  {
    $anterior = $this->buscarIndexDeObjetoPeloNome( $nome );
    if ( !$anterior === -1 )
    {
      $this->insumos[ $anterior ] = $objeto;
    }
    return;
  }

  public function obterSomatorioCustoTodosInsumos(): float
  {
    $custo = 0.0;

    if ( $this->eMaiorQueZero() )
    {
      for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
      {
        $custo += $this->insumos[$i]->obterCusto();
      }
      return $custo;
    }
    throw new \Exception( "Zero insumos impossibilitam somatorio" );
  }

  public function obterContagemInsumosUnitarios(): int
  {
    $contagem = 0;
    
    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[ $i ] instanceof InsumoUnitario )
      {
        $contagem += 1;
      }
    }

    return $contagem;
  }

  public function obterSomatorioAreaInsumosQuadrados(): float
  {
    $area = 0.0;
    
    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[ $i ] instanceof InsumoQuadrado )
      {
        $area += $this->insumos[ $i ]->obterMetrosQuadrados();
      }
    }

    return $area;
  }

  //----------------------------------------------------------------

  protected function buscarIndexDeObjetoPeloNome( string $nome ): int
  {
    $this->validarStringBusca( $nome );

    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[$i]->obterNome() == $nome )
      {
        return $i;
      }
    }
    return -1;
  }

  //----------------------------------------------------------------

  protected function validarStringBusca( string $proposta ): void
  {
    if ( !is_string( $nome ) && !(strlen($proposta) > 0) )
    {
      throw new \Exception( "String de busca inválida: $proposta" );
    }
    return;
  }

  protected function validarTipoObjeto( $objeto ): void
  {
    if ( !$this->eInsumo( $objeto ) )
    {
      throw new \Exception( "Objeto não AInsumo detectado." );
    }
  }

  protected function validarTiposObjetos( $arrayObjetos ): void
  {
    if ( !$this->saoTodosInsumos( $arrayObjetos ) )
    {
      throw new \Exception( "Objeto não AInsumo detectado em Array." );
    }
  }

  protected function validarUnicidadeDeNomes( $arrayObjetos ): void
  {
    if ( !$this->saoTodosPossuidoresNomesDiferentes( $arrayObjetos ) )
    {
      throw new \Exception( "Array de objetos possui nomes redundântes." );
    }
  }

  //---------------------------------------------------------------------

  protected function eInsumo( $objeto ): bool
  {
    if ( $objeto instanceof AInsumo )
    {
      return true;
    }
    return false;
  }

  protected function saoTodosInsumos( $arrayObjetos ): bool
  {
    for ( $i = 0; $i < sizeof($arrayObjetos); $i++ )
    {
      if ( !$this->eInsumo( $arrayObjetos[ $i ] ) )
      {
        return false;
      }
      continue;
    }
    return true;
  }

  /* Requer garantia de que todos objetos são Insumos */
  protected function saoTodosPossuidoresNomesDiferentes( $arrayObjetos ): bool
  {
    $nomes = array();

    // inicialização
    for ( $i = 0; $i < sizeof( $arrayObjetos ); $i++ )
    {
      $nomes[ $arrayObjetos[ $i ]->obterNome() ] = 1;
    }

    // busca linear marcando redundâncias
    for ( $i = 0; $i < sizeof( $arrayObjetos ); $i++ )
    {
      $nomes[ $arrayObjetos[ $i ]->obterNome() ] += 1;
    }

    //Mais de um -> false
    for ( $i = 0; $i < sizeof( $arrayObjetos ); $i++ )
    {
      if ( !($nomes[ $i ] === 1) )
      {
        return false;
      }
      continue;
    }

    return true;
  }

  protected function eMaiorQueZero(): bool
  {
    if ( sizeof( $this->insumos ) > 0 )
    {
      return true;
    }
    return false;
  }

}
