<?php

namespace App\Tests\Api\Book;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiBook;
use App\Factory\BookFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UpdateBookTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testUpdateBook(): void
    {
        $book = BookFactory::createOne(['title' => 'Old Title']);

        static::createClient()->request('PATCH', '/books/'.$book->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'title' => 'New Title',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiBook::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/books/'.$book->getId(),
            '@type' => 'Book',
            'title' => 'New Title',
            'author' => '/authors/'.$book->getAuthor()?->getId(),
        ]);
    }
}
