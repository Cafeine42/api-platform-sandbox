<?php

namespace App\ObjectMapper;

use App\Api\Resource\ApiAuthor;
use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Component\ObjectMapper\TransformCallableInterface;
use Webmozart\Assert\Assert;

/**
 * Explicitly transform ApiAuthor to Author because Symfony ObjectMapper does not yet support nested transformation automatically when mapping CreateBook to Book.
 *
 * @implements TransformCallableInterface<ApiAuthor, Author>
 */
final readonly class ApiAuthorToAuthorTransformer implements TransformCallableInterface
{
    public function __construct(private AuthorRepository $authorRepository)
    {
    }

    public function __invoke(mixed $value, object $source, ?object $target): ?Author
    {
        if (null === $value) {
            return null;
        }

        Assert::isInstanceOf($value, ApiAuthor::class, sprintf('expect an instance of %s', ApiAuthor::class));

        return $this->authorRepository->findOneBy(['id' => $value->id]);
    }
}
