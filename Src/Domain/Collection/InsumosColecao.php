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
    $this->validarUnicidadeDeIds( $insumos );

    $this->insumos = $insumos;
    $this->custo = $this->obterSomatorioCustoTodosInsumos();
  }

  public function adicionar( AInsumo $objeto ): void
  {
    $this->validarNovoInsumo( $objeto );
    array_push( $this->insumos, $objeto );
  }

  public function buscarPorId( int $id ): AInsumo | NULL
  {
    $indicie = $this->buscarIndicieInsumoPeloId( $id );

    if ( $indicie !== -1 )
    {
      return $this->insumos[ $indicie ];
    }
    return NULL;
  }

  public function buscarPorNome( string $nome ): AInsumo | NULL
  {
    $this->validarStringBusca( $nome );
    
    $indicie = $this->buscarIndicieInsumoPeloNome( $nome );

    if ( $indicie !== -1 )
    {
      return $this->insumos[ $indicie ];
    }
    return NULL;
  }

  public function removerPorId( int $id ): AInsumo | NULL
  {
    $indicie = $this->buscarIndicieInsumoPeloId( $id );

    if ( $indicie !== -1 )
    {
      return array_splice( $this->insumos, $indicie, 1 )[0];
    }
    throw new \Exception( "elemento com id \"" . $id . "\" para ser removido não existe." );
  }

  public function removerPorNome( string $nome ): AInsumo | NULL
  {
    $indicie = $this->buscarIndicieInsumoPeloNome( $nome );

    if ( $indicie !== -1 )
    {
      return array_splice( $this->insumos, $indicie, 1 )[0];
    }
    throw new \Exception( "elemento com nome \"" . $nome . "\" para ser removido não existe." );
  }

  public function substituirPorId( int $id, AInsumo $novo ): void
  {
    $indicie = $this->buscarIndicieInsumoPeloId( $id );

    if ( $indicie !== -1 )
    {
      $this->insumos[ $indicie ] = $novo;
      return;
    }
    throw new \Exception( "elemento com id \"" . $id . "\" para ser substituido não existe." );
  }

  public function substituirPorNome( string $nome, AInsumo $novo ): void
  {
    $anterior = $this->buscarIndicieInsumoPeloNome( $nome );

    if ( $anterior !== -1 )
    {
      $this->insumos[ $anterior ] = $novo;
      return;
    }
    throw new \Exception( "elemento com nome \"" . $nome . "\" para ser substituido não existe." );
  }

  //----------------------------------------------------------------

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
        $contagem += $this->insumos[ $i ]->obterQuantidadeUnidades();
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

  public function obterColecao(): array
  {
    return $this->insumos;
  }

  public function obterTotalInsumos(): int
  {
    return sizeof( $this->insumos );
  }

  //----------------------------------------------------------------

  protected function buscarIndicieInsumoPeloNome( string $nome ): int
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

  protected function buscarIndicieInsumoPeloId( int $id ): int
  {
    for ( $i = 0; $i < sizeof( $this->insumos ); $i++ )
    {
      if ( $this->insumos[$i]->obterId() == $id )
      {
        return $i;
      }
    }
    return -1;
  }

  //----------------------------------------------------------------

  protected function validarStringBusca( string $proposta ): void
  {
    if ( !is_string( $proposta ) && !(strlen($proposta) > 0) )
    {
      throw new \Exception( "String de busca inválida: $proposta" );
    }
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

  protected function validarUnicidadeDeIds( $arrayObjetos ): void
  {
    if ( !$this->saoTodosIdsDiferentes( $arrayObjetos ) )
    {
      throw new \Exception( "Array de objetos possui conflito de identificadores." );
    }
  }

  protected function validarNovoInsumo( AInsumo $proposto ): void
  {
    for ( $i = 0; $i < (sizeof($this->insumos)); $i++ )
    {
      if ( $this->insumos[ $i ]->obterId() === $proposto->obterId() )
      {
        throw new \Exception( "Identificador já existe na coleção." );
        break;
      }

      if ( $this->insumos[ $i ]->obterNome() === $proposto->obterNome() )
      {
        throw new \Exception( "Nome já existe na coleção." );
        break;
      }
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
      $nomes[ $arrayObjetos[ $i ]->obterNome() ] = 0;
    }

    // busca linear marcando redundâncias
    for ( $i = 0; $i < sizeof( $arrayObjetos ); $i++ )
    {
      $nomes[ $arrayObjetos[ $i ]->obterNome() ] += 1;
    }

    //Mais de um -> false
    foreach ( $nomes as $nome )
    {
      if ( $nome > 1 )
      {
        return false;
      }
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

  protected function saoTodosIdsDiferentes( $arrayObjetos ): bool
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
