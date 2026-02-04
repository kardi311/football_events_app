<?php

namespace App\PayloadValidator;

use App\Exception\InvalidApiRequestException;

class GoalEventValidator
{
    /**
     * @param mixed[] $payload
     * @return void
     */
    public function validate(array $payload): void
    {
        if (!isset($payload['type'])) {
            throw new InvalidApiRequestException('Event type is required');
        }

        if (!isset($payload['match_id']) || !isset($payload['team_id'])) {
            throw new InvalidApiRequestException('match_id and team_id are required for goal events');
        }
    }
}
