<?php

namespace App\Tests\Api\Book;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Api\Resource\ApiBook;
use App\Factory\AuthorFactory;
use App\Factory\BookFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class UpdateBookTest extends ApiTestCase
{
    use Factories;
    use ResetDatabase;

    public function testUpdateBookTitle(): void
    {
        $book = BookFactory::createOne([
            'title' => 'Old Title',
            'author' => AuthorFactory::createOne(),
        ]);

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
            'author' => '/authors/'.$book->getAuthor()?->getId(), // Fail
        ]);
    }

    public function testUpdateBookAuthor(): void
    {
        $book = BookFactory::createOne([
            'title' => 'Old Title',
            'author' => AuthorFactory::createOne(),
        ]);

        $anotherAuthor = AuthorFactory::createOne();

        static::createClient()->request('PATCH', '/books/'.$book->getId(), [
            'headers' => [
                'Content-Type' => 'application/merge-patch+json',
            ],
            'json' => [
                'author' => '/authors/'.$anotherAuthor->getId(),
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertMatchesResourceItemJsonSchema(ApiBook::class);

        $this->assertJsonContains([
            '@context' => '/contexts/Book',
            '@id' => '/books/'.$book->getId(),
            '@type' => 'Book',
            'title' => 'Old Title',
            'author' => '/authors/'.$anotherAuthor->getId(),
        ]);
    }
}
