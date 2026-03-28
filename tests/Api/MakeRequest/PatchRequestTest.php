<?php

namespace App\Tests\Api\MakeRequest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class PatchRequestTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testPatchRequest(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne();

        $client->request('PATCH', '/api/make_requests/'.$applicationRequest->id, [
            'headers' => ['Content-Type' => 'application/merge-patch+json'],
            'json' => [
                'comment' => 'Updated comment',
            ],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'comment' => 'Updated comment',
        ]);
    }
}
