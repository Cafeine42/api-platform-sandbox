<?php

namespace App\Api\Dto\Request;

use App\Enum\RequestStatus;

class OutputDto
{
    public ?int $id = null;
    public ?string $comment = null;
    public RequestStatus $status;
}
