<?php

namespace App\Tests\Api\Tracking;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class GetCollectionTrackingTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testGetCollection(): void
    {
        $client = static::createClient();
        ApplicationRequestFactory::createSequence([
            ['comment' => 'Tracking comment 1'],
            ['comment' => 'Tracking comment 2'],
        ]);

        $client->request('GET', '/api/trackings', ['headers' => ['Accept' => 'application/ld+json']]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            'member' => [
                ['comment' => 'Tracking comment 1'],
                ['comment' => 'Tracking comment 2'],
            ],
            'totalItems' => 2,
        ]);
    }
}
