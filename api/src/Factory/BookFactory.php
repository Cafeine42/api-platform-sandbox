<?php

namespace App\Factory;

use App\Entity\Book;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;

/**
 * @extends PersistentObjectFactory<Book>
 */
final class BookFactory extends PersistentObjectFactory
{
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Book::class;
    }

    #[\Override]
    protected function defaults(): array|callable
    {
        return [
            'title' => self::faker()->sentence(),
            'author' => AuthorFactory::new(),
        ];
    }

    #[\Override]
    protected function initialize(): static
    {
        return $this;
    }
}
