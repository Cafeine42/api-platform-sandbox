<?php

namespace App\Api\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Dto\CreateAuthor;
use App\Api\Dto\UpdateAuthor;
use App\Entity\Author;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[ApiResource(
    shortName: 'Author',
    operations: [
        new Get(name: 'ReadAuthor'),
        new GetCollection(name: 'GetAuthors'),
        new Post(
            input: CreateAuthor::class,
            name: 'CreateAuthor'
        ),
        new Patch(
            input: UpdateAuthor::class,
            name: 'UpdateAuthor'
        ),
    ],
    stateOptions: new Options(entityClass: Author::class),
)]
#[Map(source: Author::class)]
class ApiAuthor
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    public string $firstName = '';

    public string $lastName = '';
}
