<?php

namespace Src\Domain\Collection;

use Src\Domain\Collection\ACollection;
use Src\Domain\Entity\ITemObterId;

use Src\Domain\Entity\AInsumo;
use Src\Domain\Entity\InsumoUnitario;
use Src\Domain\Entity\InsumoQuadrado;

/** Representa coleção de objetos
 *  onde cada objeto representa N insumos
 *  de uma determinada caracteristica.
 *  */
class InsumosColecao extends ACollection
{

  private float $custo;

  const string TIPO = "AInsumo";

  /** Herdeira de ACollection não exige className */
  public function __construct( array $insumos )
  {
    $this->validarUnicidadeDeNomes( $insumos );
    parent::__construct( $insumos, InsumosColecao::TIPO );

    $this->custo = $this->obterSomatorioCustoTodosInsumos();
  }

  public function adicionar( AInsumo $insumo ): void
  {
    $this->validarUnicidadeDeIdsParaNovoElemento( $insumo );
    $this->validarUnicidadeDeNomeNovoInsumo( $insumo );
    array_push( $this->lista, $insumo );
  }

  public function buscarPorNome( string $nome ): AInsumo
  {
    $indicie = $this->buscarLinearmenteIndicieInsumoPeloNome( $nome );

    if ( !($indicie !== -1) )
    {
      throw new \Exception( "elemento com nome \"" . $nome . "\" buscado não existe." );
    }

    return $this->lista[ $indicie ];
  }

  public function removerPorNome( string $nome ): AInsumo
  {
    $indicie = $this->buscarLinearmenteIndicieInsumoPeloNome( $nome );

    if ( !($indicie !== -1) )
    {
      throw new \Exception( "elemento com nome \"" . $nome . "\" para ser removido não existe." );
    }

    return array_splice( $this->lista, $indicie, 1 )[0];
  }

  public function substituirPorNome( string $nome, AInsumo $novo ): AInsumo
  {
    $anterior = $this->buscarLinearmenteIndicieInsumoPeloNome( $nome );

    if ( !($anterior !== -1) )
    {
      throw new \Exception( "elemento com nome \"" . $nome . "\" para ser substituido não existe." );
    }

    $this->lista[ $anterior ] = $novo;
    return $this->lista[ $anterior ];
  }

  //----------------------------------------------------------------

  public function obterSomatorioCustoTodosInsumos(): float
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $custo = 0.0;

    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      $custo += $this->lista[$i]->obterCusto();
    }

    return $custo;
  }

  public function obterContagemInsumosUnitarios(): int
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $contagem = 0;
    
    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      if ( $this->lista[ $i ] instanceof InsumoUnitario )
      {
        $contagem += $this->lista[ $i ]->obterQuantidadeUnidades();
      }
    }

    return $contagem;
  }

  public function obterSomatorioAreaInsumosQuadrados(): float
  {
    $this->validarNumeroMinimoElementos( $this->lista );
    $area = 0.0;
    
    for ( $i = 0; $i < sizeof( $this->lista ); $i++ )
    {
      if ( $this->lista[ $i ] instanceof InsumoQuadrado )
      {
        $area += $this->lista[ $i ]->obterMetrosQuadrados();
      }
    }

    return $area;
  }

  //----------------------------------------------------------------

  private function buscarLinearmenteIndicieInsumoPeloNome( string $nome ): int
  {
    for ( $i = 0; $i < $this->obterNumeroElementos(); $i++ )
    {
      if ( $this->lista[$i]->obterNome() === $nome )
      {
        return $i;
      }
    }
    return -1;
  }

  //----------------------------------------------------------------


  private function validarUnicidadeDeNomes( array $objetos ): void
  {
    $this->validarTiposElementos( $objetos, InsumosColecao::TIPO );
    if ( !$this->saoTodosPossuidoresNomesDiferentes( $objetos ) )
    {
      throw new \Exception( "Array de objetos possui nomes redundântes." );
    }
  }

  private function validarUnicidadeDeNomeNovoInsumo( AInsumo $proposto ): void
  {
    for ( $i = 0; $i < (sizeof($this->lista)); $i++ )
    {
      if ( $this->lista[ $i ]->obterNome() === $proposto->obterNome() )
      {
        throw new \Exception( "Nome já existe na coleção." );
      }
    }
  }

  //---------------------------------------------------------------------

  /* Requer garantia de que todos objetos são AInsumo */
  private function saoTodosPossuidoresNomesDiferentes( array $objetos ): bool
  {
    // dicionário
    $nomes = array();

    // inicialização
    for ( $i = 0; $i < sizeof( $objetos ); $i++ )
    {
      $nomes[ $objetos[ $i ]->obterNome() ] = 0;
    }

    // busca linear marcando redundâncias
    for ( $i = 0; $i < sizeof( $objetos ); $i++ )
    {
      $nomes[ $objetos[ $i ]->obterNome() ] += 1;
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

}
