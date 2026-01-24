<?php

namespace App\Api\Dto;

use App\Api\Resource\ApiAuthor;
use App\Entity\Book;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Book::class)]
class CreateBook
{
    #[Assert\NotBlank]
    public string $title = '';

    #[Assert\NotNull]
    public ?ApiAuthor $author = null;
}
