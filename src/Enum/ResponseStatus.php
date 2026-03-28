<?php

namespace App\Enum;

enum ResponseStatus: string
{
    case TO_PROCESS = 'to_process';
    case BLOCKED = 'blocked';
    case ANSWERED = 'answered';
}
