<?php

namespace Src\Domain\Enum;

// Relações com prazo purgadas.
enum EServicoEstado: string
{
    case Pedente = "P";                 // Não está sendo trabalhado.
    case Progredinte = "PR";            // Está sendo trabalhado.
    case Concluido = "C";               // Todas peças concluidas.
    case Concluido_parcialmente = "CP";
    case Abortado = "AB";               // Totalmente descartado.
}
