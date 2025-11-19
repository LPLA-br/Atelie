<?php

namespace Src\Domain\ValueObject;

class Prazo
{

  protected string $FORMATO = "Y-m-d";

  protected string $dataPrazo;

  protected array $anoMesDia;
  protected bool $indeterminado;

  protected string $INDETERMINACAO = '0000-00-00';

  /** Constroi prazo sempre relativo a hoje */
  public function __construct( string $prazo )
  {
    if ( !$this->eValidoAnoMesDia( $prazo ) )
    {
      $this->dispararExcecaoDeFormatoInvalido();
    }

    $this->dataPrazo = $prazo;
    $this->anoMesDia = $this->segmentarAnoMesDiaParaObjeto( $prazo );
    $this->indeterminado = false;
  }

  public function definirPrazo( string $prazo ): void
  {
    $this->validarAcaoSobrePrazoDeterminado();

    if ( !$this->eValidoAnoMesDia( $prazo ) )
    {
      $this->dispararExcecaoDeFormatoInvalido();
    }

    if ( !$this->estaNoPrazo( $prazo ) )
    {
      $this->dispararExcecaoDePrazoNoPassado();
    }

    $this->dataPrazo = $prazo;
  }

  public function extenderPrazo( string $prazo ): void
  {
    $this->validarAcaoSobrePrazoDeterminado();

    if ( !$this->eValidoAnoMesDia( $prazo ) )
    {
      $this->dispararExcecaoDeFormatoInvalido();
    }

    if ( !$this->estaNoPrazo( $prazo ) )
    {
      $this->dispararExcecaoDePrazoNoPassado();
    }

    $this->dataPrazo = $prazo;
  }

  public function indeterminarPrazo(): void
  {
    $this->dataPrazo = $this->INDETERMINACAO;
    $this->indeterminado = true;
  }

  public function restaurarPrazo(): void
  {
    if ( !$this->estaNoPrazo( $this->dataPrazo ) )
    {
      print_r( "prazo restaurado para um dia a frente" );
      $this->dataPrazo = new \DateTime( date( $this->FORMATO ) )->modify('+1 days')->format($this->FORMATO);
      $this->indeterminado = false;
      return;
    }
  }

  public function obterFormatoAdotado(): string
  {
    return $this->FORMATO;
  }

  public function obterPrazo(): string
  {
    return $this->dataPrazo;
  }

  public function estaIndeterminado(): bool
  {
    return $this->indeterminado;
  }

  public function estaPrazoUltrapassado(): bool
  {
    return !($this->estaNoPrazo( $this->dataPrazo ));
  }

  //-------------------------------------------------

  /* Verifica se prazo não foi definido para o passado. */
  protected function estaNoPrazo( string $dataProposta ): bool
  {
    $hoje = date( $this->FORMATO );

    if ( $hoje <= $dataProposta )
    {
        return true;
    }
    return false;
  }

  protected function estaAlemDoPrazoCorrente( string $dataProposta ): bool
  {
    if ( $this->dataPrazo < $dataProposta )
    {
      return true;
    }
    return false;
  }

  /* Verifica se o formato de string bate com formato Y-m-d */
  protected function eValidoAnoMesDia( string $data ): bool
  {
    $string = "/[0-9]{4}-[0-9]{2}-[0-9]{2}/";

    if ( preg_match( $string, $data ) )
    {
      $AnoMesDia = $this->segmentarAnoMesDiaParaObjeto( $data );

      if ( checkdate( $AnoMesDia["mes"], $AnoMesDia["dia"], $AnoMesDia["ano"] ) )
      {
        return true;
      }
    }
    return false;
  }

  protected function segmentarAnoMesDiaParaObjeto( string $data ): array
  {
    $segmentos = explode( '-', $data );

    return array(
      "ano" => $segmentos[0],
      "mes" => $segmentos[1],
      "dia" => $segmentos[2]
    );
  }

  /* invalida ações sobre prazos indeterminados */
  protected function validarAcaoSobrePrazoDeterminado(): void
  {
    if ( $this->indeterminado )
    {
      throw new \Exception( "Prazo: Ação no prazo inválida pois ele está indeterminado." );
    }
  }

  protected function dispararExcecaoDeFormatoInvalido(): void
  {
    throw new \Exception( "Prazo: Extensão de prazo falhou por formato não Y-m-d" );
  }

  protected function dispararExcecaoDePrazoNoPassado(): void
  {
    throw new \Exception( "prazo definido está no passado." );
  }
}
