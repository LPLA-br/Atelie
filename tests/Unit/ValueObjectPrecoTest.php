<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Preco as Preco;

final class ValueObjectPrecoTest extends TestCase
{
  public function testarPrecoNuloFuncional()
  {
    $instancia = new Preco( 0.0 );
  }

  public function testarPrecoMenorZeroExcepciona()
  {
    $this->expectException( Throwable::class );
    $instancia = new Preco( -1.0 );
  }
}


