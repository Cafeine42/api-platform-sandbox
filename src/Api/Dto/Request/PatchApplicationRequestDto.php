<?php

namespace App\Api\Dto\Request;

use App\Entity\ApplicationRequest;
use App\Enum\RequestStatus;
use App\Validator\Constraints\SkipNonInitialized;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: ApplicationRequest::class)]
class PatchApplicationRequestDto
{
    #[SkipNonInitialized(new Assert\NotBlank())]
    #[Map(target: 'comment')]
    public string $comment;

    #[Map(target: 'status')]
    public RequestStatus $status;
}
