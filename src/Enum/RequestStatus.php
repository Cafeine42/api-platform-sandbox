<?php

namespace App\Enum;

enum RequestStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case ANSWERED = 'answered';
}
