<?php

namespace App\Api\Dto;

use App\Api\Resource\ApiAuthor;
use App\Entity\Book;
use App\ObjectMapper\ApiAuthorToAuthorTransformer;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Book::class)]
class CreateBook
{
    #[Assert\NotBlank]
    public string $title = '';

    #[Assert\NotNull]
    #[Map(transform: ApiAuthorToAuthorTransformer::class)] // Explicitly transform ApiAuthor to Author because Symfony ObjectMapper does not yet support nested transformation automatically when mapping CreateBook to Book
    public ?ApiAuthor $author = null;
}
