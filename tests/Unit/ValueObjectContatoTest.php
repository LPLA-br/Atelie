<?php

use PHPUnit\Framework\TestCase;
use Src\Domain\ValueObject\Contato as Contato;

final class ValueObjectContatoTest extends TestCase
{
  public function testInstanciacaoNormalFunciona()
  {
    $c = new Contato( "123456789", "foo@bar.com" );
    $this->assertEquals( ($c instanceof Contato), true );
  }

  public function testNumerosAbsurdosExcepcionam()
  {
    $this->expectException( Throwable::class );
    $c = new Contato( "", "foo@bar.com" );
    $c = new Contato( "abcdefghi", "foo@bar.com" );
    $c = new Contato( "1", "foo@bar.com" );
    $c = new Contato( "69", "foo@bar.com" );
    $c = new Contato( "12a45k7 9", "foo@bar.com" );
  }

  public function testEmailAbsurdoExcepcionam()
  {
    $this->expectException( Throwable::class );
    $c = new Contato( "123456789", "123 @bar.com" );
    $c = new Contato( "123456789", "123@ bar.com" );
    $c = new Contato( "123456789", "123 @ bar.com" );
    $c = new Contato( "123456789", "123@.com" );
    $c = new Contato( "123456789", "@bar.com" );
    $c = new Contato( "123456789", "@.com" );
    $c = new Contato( "123456789", ".com" );
    $c = new Contato( "123456789", "" );
  }
}
