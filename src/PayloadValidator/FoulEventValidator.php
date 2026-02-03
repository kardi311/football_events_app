<?php

namespace App\PayloadValidator;

class FoulEventValidator
{
    public function validate(array $payload): void
    {
        if (!isset($payload['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        if (!isset($payload['match_id']) || !isset($payload['team_id'])) {
            throw new \InvalidArgumentException('match_id and team_id are required for foul events');
        }
    }
}
