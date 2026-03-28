<?php

namespace App\Tests\Api\MakeResponse;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Enum\ResponseStatus;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class CreateResponseTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testCreateResponse(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/make_responses', [
            'headers' => ['Content-Type' => 'application/ld+json'],
            'json' => [
                'responseComment' => 'This is a test response comment',
                'responseStatus' => ResponseStatus::TO_PROCESS->value,
            ],
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            'responseComment' => 'This is a test response comment',
            'responseStatus' => ResponseStatus::TO_PROCESS->value,
        ]);
    }
}
