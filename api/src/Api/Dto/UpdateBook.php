<?php

namespace App\Api\Dto;

use App\Api\Resource\ApiAuthor;
use App\Entity\Book;
use App\ObjectMapper\ApiAuthorToAuthorTransformer;
use App\ObjectMapper\Condition\IsNotNullCondition;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Book::class)]
class UpdateBook
{
    #[Assert\NotBlank(allowNull: true)]
    public string $title;

    #[Map(if: IsNotNullCondition::class, transform: ApiAuthorToAuthorTransformer::class)]
    public ?ApiAuthor $author = null;
}
