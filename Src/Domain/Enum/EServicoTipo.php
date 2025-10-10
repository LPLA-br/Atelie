<?php

namespace Src\Domain\Enum;

enum EServicoTipo: string
{
    //
    case Confeccao = 'CF';
    case Conserto = 'CS';
    case Confeccao_e_concerto = 'CFS';
}
