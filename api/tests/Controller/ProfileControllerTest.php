<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\ApiTestCase;
use ApiPlatform\Symfony\Bundle\Test\Client;
use App\Controller\ProfileController;
use App\Tests\Api\RefreshDatabaseTrait;

/**
 * @see ProfileController
 */
final class ProfileControllerTest extends ApiTestCase
{
    use RefreshDatabaseTrait;

    private Client $client;

    protected function setup(): void
    {
        $this->client = self::createClient();
    }

    /**
     * @see ProfileController::__invoke()
     */
    public function testProfile(): void
    {
        $this->client->request('GET', '/profile', ['auth_bearer' => 'user@example.com']);
        self::assertResponseIsSuccessful();
        self::assertResponseHeaderSame('content-type', 'application/json');
        self::assertJsonContains([
            'email' => 'user@example.com',
            'roles' => ['ROLE_USER'],
        ]);
    }
}
