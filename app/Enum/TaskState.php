<?php

namespace App\Enum;

Enum TaskState: string
{
    case TO_DO = 'À Faire';
    case IN_PROGRESS = 'En Cours';
    case PENDING = 'En Attente';
    case IN_MERGE_REQUEST = 'En MR';
    case DONE = 'Terminé';
}
