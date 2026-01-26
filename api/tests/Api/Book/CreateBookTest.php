<?php

namespace App\Tests\Api\Book;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiBook;
use App\Factory\AuthorFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateBookTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateBook(): void
    {
        $author = AuthorFactory::createOne();

        static::createClient()->request('POST', '/books', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'title' => '1984',
                'author' => '/authors/'.$author->getId(),
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiBook::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@type' => 'Book',
            'title' => '1984',
            'author' => '/authors/'.$author->getId(),
        ]);
    }
}
