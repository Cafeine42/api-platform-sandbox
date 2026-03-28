<?php

namespace App\Tests\Api\Tracking;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetTrackingTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetItem(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne(['comment' => 'Tracking comment']);

        $client->request('GET', '/api/trackings/'.$applicationRequest->id);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'comment' => 'Tracking comment',
        ]);
    }
}
