<?php

namespace App\Api\Dto\Response;

use App\Entity\ApplicationRequest;
use App\Enum\ResponseStatus;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: ApplicationRequest::class)]
class CreateApplicationResponseDto
{
    #[Assert\NotBlank]
    #[Map(target: 'responseComment')]
    public string $responseComment;

    #[Assert\NotNull]
    #[Map(target: 'responseStatus')]
    public ResponseStatus $responseStatus;
}
