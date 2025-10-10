<?php

namespace Src\Domain\Enum;

enum EPecaEstado: string
{
    case Pendente = "PD";
    case Progredinte = "P";
    case Concluida = "C";
    case Abortada = "A";
}
