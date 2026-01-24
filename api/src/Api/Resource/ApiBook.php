<?php

namespace App\Api\Resource;

use ApiPlatform\Doctrine\Orm\State\Options;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Api\Dto\CreateBook;
use App\Api\Dto\UpdateBook;
use App\Entity\Book;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    shortName: 'Book',
    operations: [
        new Get(name: 'ReadBook'),
        new GetCollection(name: 'GetBooks'),
        new Post(
            input: CreateBook::class,
            name: 'CreateBook'
        ),
        new Patch(
            input: UpdateBook::class,
            name: 'UpdateBook'
        ),
    ],
    stateOptions: new Options(entityClass: Book::class),
)]
#[Map(source: Book::class)]
class ApiBook
{
    #[ApiProperty(identifier: true)]
    public ?int $id = null;

    #[Assert\NotBlank]
    #[Map(source: 'title')]
    public string $title = '';

    #[Assert\NotNull]
    public ?ApiAuthor $author = null;
}
