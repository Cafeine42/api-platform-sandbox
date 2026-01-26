<?php

namespace App\Api\Dto;

use App\Api\Resource\ApiAuthor;
use App\Entity\Book;
use App\ObjectMapper\ApiAuthorToAuthorTransformer;
use App\ObjectMapper\Condition\IsNotNullCondition;
use Symfony\Component\ObjectMapper\Attribute\Map;

#[Map(target: Book::class)]
class UpdateBook
{
    public string $title;

    #[Map(transform: ApiAuthorToAuthorTransformer::class)]
    //    #[Map(if: IsNotNullCondition::class, transform: ApiAuthorToAuthorTransformer::class)]
    public ?ApiAuthor $author = null;
}
