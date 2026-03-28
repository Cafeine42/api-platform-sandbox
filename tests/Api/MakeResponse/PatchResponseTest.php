<?php

namespace App\Tests\Api\MakeResponse;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PatchResponseTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPatchResponse(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne();

        $client->request('PATCH', '/api/make_responses/'.$applicationRequest->id, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'responseComment' => 'Updated response comment',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'responseComment' => 'Updated response comment',
        ]);
    }
}
