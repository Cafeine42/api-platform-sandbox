<?php

namespace App\Api\Dto\Request;

use App\Entity\ApplicationRequest;
use App\Enum\RequestStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: ApplicationRequest::class)]
class CreateApplicationRequestDto
{
    #[Assert\NotBlank]
    #[Map(target: 'comment')]
    public string $comment;

    #[Map(target: 'status')]
    public RequestStatus $status = RequestStatus::DRAFT;
}
