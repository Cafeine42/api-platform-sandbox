<?php

namespace App\Tests\Api\Tracking;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Factory\ApplicationRequestFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class DeleteTrackingTest extends ApiTestCase
{
    use ResetDatabase;
    use Factories;

    public function testDeleteItem(): void
    {
        $client = static::createClient();
        $applicationRequest = ApplicationRequestFactory::createOne();

        $client->request('DELETE', '/api/trackings/'.$applicationRequest->id);

        $this->assertResponseStatusCodeSame(204);
        ApplicationRequestFactory::assert()->empty();
    }
}
