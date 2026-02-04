<?php

namespace App\Tests\Unit\PayloadValidator;

use App\PayloadValidator\GoalEventValidator;
use App\Exception\InvalidApiRequestException;
use PHPUnit\Framework\TestCase;

class GoalEventValidatorTest extends TestCase
{
    private GoalEventValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new GoalEventValidator();
    }

    public function testValidateSuccess(): void
    {
        $payload = [
            'type' => 'goal',
            'match_id' => 1,
            'team_id' => 10
        ];

        $this->validator->validate($payload);
        $this->assertTrue(true);
    }

    public function testValidateThrowsExceptionWhenTypeIsMissing(): void
    {
        $this->expectException(InvalidApiRequestException::class);
        $this->expectExceptionMessage('Event type is required');

        $this->validator->validate([
            'match_id' => 1,
            'team_id' => 10
        ]);
    }

    public function testValidateThrowsExceptionWhenMatchIdIsMissing(): void
    {
        $this->expectException(InvalidApiRequestException::class);
        $this->expectExceptionMessage('match_id and team_id are required for goal events');

        $this->validator->validate([
            'type' => 'goal',
            'team_id' => 10
        ]);
    }

    public function testValidateThrowsExceptionWhenTeamIdIsMissing(): void
    {
        $this->expectException(InvalidApiRequestException::class);
        $this->expectExceptionMessage('match_id and team_id are required for goal events');

        $this->validator->validate([
            'type' => 'goal',
            'match_id' => 1
        ]);
    }
}
