<?php

namespace App\Api\Dto;

use App\Entity\Author;
use Symfony\Component\ObjectMapper\Attribute\Map;
use Symfony\Component\Validator\Constraints as Assert;

#[Map(target: Author::class)]
class UpdateAuthor
{
    #[Assert\NotBlank(allowNull: true)]
    public string $firstName;

    #[Assert\NotBlank(allowNull: true)]
    public string $lastName;
}
