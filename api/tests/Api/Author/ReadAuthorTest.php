<?php

namespace App\Tests\Api\Author;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiAuthor;
use App\Factory\AuthorFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class ReadAuthorTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testReadAuthor(): void
    {
        $author = AuthorFactory::createOne(['firstName' => 'John', 'lastName' => 'Doe']);

        static::createClient()->request('GET', '/authors/'.$author->getId());

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiAuthor::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Author',
            '@id' => '/authors/'.$author->getId(),
            '@type' => 'Author',
            'firstName' => 'John',
            'lastName' => 'Doe',
        ]);
    }
}
