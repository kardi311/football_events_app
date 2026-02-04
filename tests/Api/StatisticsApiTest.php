<?php

namespace Api;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Zenstruck\Foundry\Test\ResetDatabase;

class StatisticsApiTest extends ApiTestCase
{
    use ResetDatabase;

    protected static ?bool $alwaysBootKernel = true;

    public function testGetTeamStatistics(): void
    {
        $client = static::createClient();
        $client->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'William Saliba',
                'team_id' => 'arsenal',
                'match_id' => 'm1',
                'minute' => 15,
                'second' => 34
            ])
        ]);
        $client->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'Gabriel Jesus',
                'team_id' => 'arsenal',
                'match_id' => 'm1',
                'minute' => 30,
                'second' => 33
            ])
        ]);


        $response = $client->request('GET', 'statistics?match_id=m1&team_id=arsenal');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($response->getContent());
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains([
            'match_id' => 'm1',
            'team_id' => 'arsenal',
            'statistics' => [
                'fouls' => 2
            ]
        ]);
    }


    public function testGetMatchStatistics(): void
    {
        $client = static::createClient();
        $client->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'William Saliba',
                'team_id' => 'arsenal',
                'match_id' => 'm1',
                'minute' => 15,
                'second' => 34
            ])
        ]);
        $client->request('POST', '/event', [
            'body' => json_encode([
                'type' => 'foul',
                'player' => 'Virgil van Dijk',
                'team_id' => 'liverpool',
                'match_id' => 'm1',
                'minute' => 30,
                'second' => 33
            ])
        ]);


        $response = $client->request('GET', 'statistics?match_id=m1');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($response->getContent());
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains([
            'match_id' => 'm1',
            'statistics' => [
                'arsenal' => [
                    'fouls' => 1
                ],
                'liverpool' => [
                    'fouls' => 1
                ]
            ]
        ]);
    }

    public function testGetStatisticsWithoutMatchId()
    {
        $client = static::createClient();
        $client->request('GET', '/statistics');

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonContains([
            'error' => 'match_id is required'
        ]);
    }


    public function testGetStatisticsForNonExistingMatchId()
    {
        $client = static::createClient();
        $response = $client->request('GET', '/statistics?match_id=nonexistent');

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJson($response->getContent());
        $this->assertResponseHeaderSame('content-type', 'application/json');
        $this->assertJsonContains([
            'match_id' => 'nonexistent',
            'statistics' => []
        ]);
    }
}


