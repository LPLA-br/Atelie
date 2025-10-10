<?php

namespace Src\Domain\ValueObject;

class Prazo
{

    protected string $FORMATO = "Y-m-d";
    protected string $dataPrazo;
    protected array $anoMesDia;
    protected bool $indeterminado;

    protected string $INDETERMINACAO = '0000-00-00';

    /**
     * Create a new class instance.
     */
    public function __construct( ?string $prazo )
    {
        if ( $prazo )
        {
            $this->dataPrazo = $this->validarFormatoAnoMesDia( $prazo ) ? $prazo : $this->dispararExcecaoDeFormatoInvalido() ;
        }
        else
        {
            $this->dataPrazo = date($this->FORMATO);
        }
        $this->anoMesDia = $this->segmentarAnoMesDiaParaArray( $prazo );
        $this->indeterminado = false;
    }

    public function definirPrazo( string $prazo ): void
    {
        $this->validarAcaoSobrePrazoDeterminado();

        if ( $this->validarFormatoAnoMesDia( $prazo ) )
        {
            $this->dataPrazo = $this->estaNoPrazo( $prazo ) ? $prazo : $this->dataPrazo ;
            return;
        }
        $this->dispararExcecaoDeFormatoInvalido();
    }

    public function extenderPrazo( string $prazo ): void
    {
        $this->validarAcaoSobrePrazoDeterminado();

        if ( $this->validarFormatoAnoMesDia( $prazo ) )
        {
            $this->dataPrazo = $this->estaAlemDoPrazoCorrente( $prazo ) ? $prazo : $this->dataPrazo ;
            return;
        }
        $this->dispararExcecaoDeFormatoInvalido();
    }

    // Indefine
    public function indeterminarPrazo(): void
    {
        $this->prazo = $this->INDETERMINACAO;
        $this->indeterminado = true;
    }

    // Define para hoje.
    public function restaurarPrazoIndeterminado(): void
    {
        if ( !$this->estaNoPrazo( $this->dataPrazo ) )
        {
            $this->prazo = date($this->FORMATO);
            print_r( "Prazo: Prazo indeterminado→determinado expirado. definido para hoje." );
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
        if ( $this->indeterminado === true ) return true;
        return false;
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

    /* Verifica se o formato de string bate com formato AAAA-MM-DD */
    protected function validarFormatoAnoMesDia( string $data ): bool
    {
        $string = "[0-9]{4}-[0-9]{2}-[0-9]{2}";

        if ( preg_match( $string, $data ) )
        {
            $AnoMesDia = $this->segmentarAnoMesDiaParaArray( $data );
            if ( checkdate( AnoMesDia["mes"], AnoMesDia["dia"], AnoMesDia["ano"] ) )
            {
                return true;
            }
        }
        return false;
    }

    protected function segmentarAnoMesDiaParaArray( string $data ): array
    {
        try
        {
            $segmentos = explode( '-', $data );

            return array(
                "ano" => $segmentos[0],
                "mes" => $segmentos[1],
                "dia" => $segmentos[2]
            );
        }
        catch ( error )
        {
            error_log( error );
            return array();
        }
    }

    /* invalida ações sobre prazos indeterminados */
    protected function validarAcaoSobrePrazoDeterminado( ?string $mensagemDeExcecao ): void
    {
        if ( $this->indeterminado === true )
        {
            if ( $mensagemDeExcecao )
            {
                throw new LogicException( "Prazo: " . $mensagemDeExcecao );
                return;
            }
            throw new LogicException( "Prazo: Ação no prazo inválida pois ele está indeterminado." );
        }
    }

    protected function dispararExcecaoDeFormatoInvalido(): void
    {
        throw new Exception( "Prazo: Extensão de prazo falhou por formato não AAAA-MM-DD" );
    }
}
