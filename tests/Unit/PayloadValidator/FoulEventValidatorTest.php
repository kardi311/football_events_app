<?php

namespace App\Tests\Unit\PayloadValidator;

use App\PayloadValidator\FoulEventValidator;
use App\Exception\InvalidApiRequestException;
use PHPUnit\Framework\TestCase;

class FoulEventValidatorTest extends TestCase
{
    private FoulEventValidator $validator;

    protected function setUp(): void
    {
        $this->validator = new FoulEventValidator();
    }

    public function testValidateSuccess(): void
    {
        $payload = [
            'type' => 'foul',
            'match_id' => 123,
            'team_id' => 45
        ];

        $this->validator->validate($payload);
        $this->assertTrue(true);
    }

    public function testValidateThrowsExceptionWhenTypeIsMissing(): void
    {
        $this->expectException(InvalidApiRequestException::class);
        $this->expectExceptionMessage('Event type is required');

        $this->validator->validate([
            'match_id' => 123,
            'team_id' => 45
        ]);
    }
}
