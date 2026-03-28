<?php

namespace App\Api\Dto\Response;

use App\Entity\ApplicationRequest;
use App\Enum\ResponseStatus;
use App\Validator\Constraints\SkipNonInitialized;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: ApplicationRequest::class)]
class PatchApplicationResponseDto
{
    #[SkipNonInitialized(new Assert\NotBlank())]
    #[Map(target: 'responseComment')]
    public string $responseComment;

    #[SkipNonInitialized(new Assert\NotNull())]
    #[Map(target: 'responseStatus')]
    public ResponseStatus $responseStatus;
}
