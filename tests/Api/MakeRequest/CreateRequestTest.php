<?php

namespace App\Tests\Api\MakeRequest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Enum\RequestStatus;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateRequestTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testCreateRequest(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/make_requests', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'comment' => 'This is a test comment',
                'status' => RequestStatus::DRAFT->value,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'comment' => 'This is a test comment',
            'status' => RequestStatus::DRAFT->value,
        ]);
    }
}
