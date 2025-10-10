<?php

namespace Src\Domain\Enum;

enum EPecaTipo: string
{
    case Vestido = "V";
    case Calsa = "C";
    case Calsao = "CA";
    case Camisa = "CM";
    case Camiseta = "CE";

    case Mochila = "MO";
    case Cueca = "CU";
    case Cinto = "CI";
}
