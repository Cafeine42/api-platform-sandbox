<?php

namespace App\Tests\Api\MakeResponse;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetResponseTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetResponse(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne(['responseComment' => 'Response comment']);

        $client->request('GET', '/api/make_responses/'.$applicationRequest->id);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'responseComment' => 'Response comment',
        ]);
    }
}
