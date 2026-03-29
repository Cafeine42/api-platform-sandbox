<?php

namespace App\Api\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Dto\Request\CreateApplicationRequestDto;
use App\Api\Dto\Request\OutputDto;
use App\Api\Dto\Request\PatchApplicationRequestDto;
use App\Entity\ApplicationRequest;
use App\Enum\RequestStatus;

#[ApiResource(
    shortName: 'MakeRequest',
    operations: [
        new Get(
            uriTemplate: '/make_requests/{id}',
            requirements: ['id' => '\d+'],
        ),
        new Post(input: CreateApplicationRequestDto::class),
        new Patch(
            uriTemplate: '/make_requests/{id}',
            requirements: ['id' => '\d+'],
            input: PatchApplicationRequestDto::class,
            output: OutputDto::class
        ),
    ],
    stateOptions: new Options(entityClass: ApplicationRequest::class),
)]
class Request
{
    public ?int $id = null;
    public ?string $comment = null;
    public RequestStatus $status;
}
