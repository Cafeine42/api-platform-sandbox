<?php

namespace App\ObjectMapper;

use App\Api\Resource\ApiAuthor;
use App\Entity\Author;
use Symfony\Component\ObjectMapper\ObjectMapperInterface;
use Symfony\Component\ObjectMapper\TransformCallableInterface;
use Webmozart\Assert\Assert;

/**
 * Explicitly transform Author to ApiAuthor because Symfony ObjectMapper does not yet support nested transformation automatically when mapping Book to ApiBook.
 *
 * @implements TransformCallableInterface<Author, ApiAuthor>
 */
final readonly class AuthorToApiAuthorTransformer implements TransformCallableInterface
{
    public function __construct(private ObjectMapperInterface $objectMapper)
    {
    }

    public function __invoke(mixed $value, object $source, ?object $target): ?ApiAuthor
    {
        Assert::nullOrIsInstanceOf($value, Author::class, sprintf('expect an instance of %s', Author::class));

        if (null === $value) {
            return null;
        }

        return $this->objectMapper->map($value, ApiAuthor::class);
    }
}
