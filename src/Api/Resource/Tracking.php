<?php

namespace App\Api\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Entity\ApplicationRequest;
use App\Enum\RequestStatus;
use App\Enum\ResponseStatus;

#[ApiResource(
    shortName: 'Tracking',
    operations: [
        new Get(
            uriTemplate: '/trackings/{id}',
            requirements: ['id' => '\d+'],
        ),
        new GetCollection(),
        new Delete(
            uriTemplate: '/trackings/{id}',
            requirements: ['id' => '\d+'],
        ),
    ],
    stateOptions: new Options(entityClass: ApplicationRequest::class),
)]
class Tracking
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;
    public ?string $comment = null;
    public RequestStatus $status;
    public ?string $responseComment = null;
    public ResponseStatus $responseStatus;
}
