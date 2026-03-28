<?php

namespace App\Tests\Api\MakeRequest;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetRequestTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetRequest(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne(['comment' => 'Request comment']);

        $client->request('GET', '/api/make_requests/'.$applicationRequest->id);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'comment' => 'Request comment',
        ]);
    }
}
