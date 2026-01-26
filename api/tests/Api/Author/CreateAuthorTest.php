<?php

namespace App\Tests\Api\Author;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiAuthor;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateAuthorTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testCreateAuthor(): void
    {
        static::createClient()->request('POST', '/authors', [
            'headers' => [
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                'firstName' => 'Jane',
                'lastName' => 'Smith',
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiAuthor::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Author',
            '@type' => 'Author',
            'firstName' => 'Jane',
            'lastName' => 'Smith',
        ]);
    }
}
