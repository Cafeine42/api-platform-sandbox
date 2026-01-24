<?php

namespace App\Tests\Api\Author;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiAuthor;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetAuthorsTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testGetCollection(): void
    {
        \App\Factory\BookFactory::truncate();
        \App\Factory\AuthorFactory::truncate();
        \App\Factory\AuthorFactory::createMany(5);

        static::createClient()->request('GET', '/authors');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceCollectionJsonSchema(ApiAuthor::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Author',
            '@id' => '/authors',
            '@type' => 'Collection',
            'totalItems' => 5,
        ]);
    }
}
