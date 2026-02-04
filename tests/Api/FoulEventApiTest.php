<?php

namespace App\Tests\Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class FoulEventApiTest extends ApiTestCase
{
    use ResetDatabase;

    protected static ?bool $alwaysBootKernel = true;

    public function testFoulEvent(): void
    {
        $response = static::createClient()->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'William Saliba',
                'team_id' => 'arsenal',
                'match_id' => 'm1',
                'minute' => 45,
                'second' => 34
            ])
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($response->getContent());
        $this->assertJsonContains([
            'status' => 'success',
            'message' => 'Event saved successfully'
        ]);
    }

    public function testFoulEventWithoutRequiredFields(): void
    {
        $client = static::createClient();
        $client->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'William Saliba',
                'minute' => 45,
                'second' => 34
                // Missing team_id and match_id
            ])
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains([
            'error' => 'match_id and team_id are required for foul events'
        ]);
    }

    public function testInvalidJson()
    {
        $client = static::createClient();
        $client->request('POST', '/event', []);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains([
            'error' => 'Invalid JSON'
        ]);
    }

    public function testEventWithoutType()
    {
        $client = static::createClient();
        $client->request('POST', '/event', [
            'body' => json_encode([
                'player' => 'John Doe',
                'minute' => 45,
                'second' => 34
            ])
        ]);

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains([
            'error' => 'Event type is required'
        ]);
    }

}


