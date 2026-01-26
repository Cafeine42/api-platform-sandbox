<?php

namespace App\Tests\Api\Author;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiAuthor;
use App\Factory\AuthorFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UpdateAuthorTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testUpdateAuthor(): void
    {
        $author = AuthorFactory::createOne(['firstName' => 'Old', 'lastName' => 'Name']);

        static::createClient()->request('PATCH', '/authors/'.$author->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'firstName' => 'New',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiAuthor::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Author',
            '@id' => '/authors/'.$author->getId(),
            '@type' => 'Author',
            'firstName' => 'New',
            'lastName' => 'Name',
        ]);
    }
}
