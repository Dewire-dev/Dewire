<?php

namespace App\Enum;

enum TaskType: string
{
    case CLIENT_PROJECT = 'Projet Client';
    case INTERNAL = 'Interne';
    case PRE_SALE = 'Avant-Vente';
}
