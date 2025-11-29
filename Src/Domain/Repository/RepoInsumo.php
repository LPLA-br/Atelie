<?php

/* Objeto nasce somente para:
 * leitura -> R     somenteLeitura=true
 * ou
 * escrita -> CUD   somenteLeitura=false
 * */

namespace \Src\Domain\Repository;

use \Src\Domain\Entity\AInsumo;

use \Src\Domain\Entity\InsumoQuadrado;
use \Src\Domain\Entity\InsumoUnitario;
use \Src\Domain\ValueObject\Preco;

class RepoInsumo extends RepoGenerico
{

  public function __construct( array $objetos )
  {
    parent::__construct( $objetos );
  }

  public function obterObjetos(): array | NULL
  {
    if ( sizeof($this->resultado) === 0 ) return ;
    $objetos = array();

    for ( $i=0; $i<sizeof($this->resultado); $i++ )
    {
      $id = (int)($this->resultado[ $i ][ "id" ]);
      $nome = $this->resultado[ $i ][ "nome" ];
      $preco = (float)($this->resultado[ $i ][ "preco" ]);
      $tipo = $this->resultado[ $i ][ "tipo" ];
      $quantidade = (float)($this->resultado[ $i ][ "quantidade" ]);

      $this->validarTipo( $tipo );

      if ( $tipo === "unitario" )
      {
        array_push( $objetos, new InsumoUnitario(
          $id,
          $nome,
          new Preco( $preco, $quantidade )
        ));
        continue;
      }
      array_push( $objetos, new InsumoQuadrado(
        $id,
        $nome,
        new Preco( $preco, $quantidade )
      ));
    }

    return $objetos;
  }

  //-----------------------------------------

  public function buscarInsumosPeloNome( string $nome ): void
  {
    $this->invalidarLeiturasPorSomenteEscrita();
    $this->ler( "SELECT * FROM insumos WHERE nome='".$nome."'" );
  }

  public function buscarInsumosPeloTipo( string $tipo ): void
  {
    $this->invalidarLeiturasPorSomenteEscrita();
    $this->ler( "SELECT * FROM insumos WHERE preco='".$tipo."'" );
  }

  public function buscarInsumosPeloPelaQuantidade( int $menor, int $maior ): void
  {
    $this->invalidarLeiturasPorSomenteEscrita();
    $this->ler( "SELECT * FROM insumos WHERE quantidade > ".$menor." and quantidade < ".$maior );
  }

  public function buscarInsumosPeloPreco( float $menor, float $maior ): void
  {
    $this->invalidarLeiturasPorSomenteEscrita();
    $this->ler( "SELECT * FROM insumos WHERE preco > ".$menor." and preco < ".$maior );
  }

  //-----------------------------------------

  public function escreverObjetosRecebidos(): void
  {
    $this->invalidarEscritasPorSomenteLeitura();
    for ( $i=0; $i<sizeof($this->resultado); $i++ )
    {
      $this->validarTipo( $this->resultado[ $i ], "AInsumo" );

      // TODO: CONTINUE AQUI SEU TONTO !
    }
  }

  //-----------------------------------------

  protected function validarTipo( string $tipo ): void
  {
    if ( $tipo !== "unitario" && $tipo !== "quadrado" )
    {
      throw new \Exception( "Registro de tipo desconhecido detectado !" );
    }
  }

  //-----------------------------------------


}

