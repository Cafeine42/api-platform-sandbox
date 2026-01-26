<?php

namespace App\Factory;

use App\Entity\Author;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Author>
 */
final class AuthorFactory extends PersistentObjectFactory
{
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Author::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'firstName' => self::faker()->firstName(),
            'lastName' => self::faker()->lastName(),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
