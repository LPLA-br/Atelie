<?php

namespace Src\Domain\Comunication;

/* Interface para classe principal do sistema que
 * executa recursos de comunicação em redes udp/ip
 * (protocolo Atelie)
 * */

interface IServidor
{
  public function obterObjetoComando(): object;
  public function ouvir(): void;
  public function fechar(): void;
  public function rotear(): void;
}

