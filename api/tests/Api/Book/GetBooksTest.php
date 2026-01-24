<?php

namespace App\Tests\Api\Book;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiBook;
use App\Factory\BookFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetBooksTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testGetCollection(): void
    {
        BookFactory::truncate();
        BookFactory::createMany(5);

        static::createClient()->request('GET', '/books');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(ApiBook::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/books',
            '@type' => 'Collection',
            'totalItems' => 5,
        ]);
    }
}
