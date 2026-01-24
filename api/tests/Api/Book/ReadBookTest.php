<?php

namespace App\Tests\Api\Book;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiBook;
use App\Factory\BookFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReadBookTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testReadBook(): void
    {
        $book = BookFactory::createOne(['title' => 'The Great Gatsby']);

        static::createClient()->request('GET', '/books/'.$book->getId());

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiBook::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/books/'.$book->getId(),
            '@type' => 'Book',
            'title' => 'The Great Gatsby',
        ]);
    }
}
