<?php

namespace App\Api\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Dto\Response\CreateApplicationResponseDto;
use App\Api\Dto\Response\PatchApplicationResponseDto;
use App\Entity\ApplicationRequest;
use App\Enum\ResponseStatus;

#[ApiResource(
    shortName: 'MakeResponse',
    operations: [
        new Get(
            uriTemplate: '/make_responses/{id}',
            requirements: ['id' => '\d+'],
        ),
        new Post(input: CreateApplicationResponseDto::class),
        new Patch(
            uriTemplate: '/make_responses/{id}',
            requirements: ['id' => '\d+'],
            input: PatchApplicationResponseDto::class
        ),
    ],
    stateOptions: new Options(entityClass: ApplicationRequest::class),
)]
class Response
{
    public ?int $id = null;
    public ?string $responseComment = null;
    public ResponseStatus $responseStatus;
}
