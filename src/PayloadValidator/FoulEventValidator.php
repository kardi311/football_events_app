<?php

namespace App\PayloadValidator;

use App\Entity\FoulEvent;

class FoulEventValidator
{
    public function validate(array $payload): void
    {
        if (!isset($payload['type'])) {
            throw new \InvalidArgumentException('Event type is required');
        }

        if (!isset($data['match_id']) || !isset($data['team_id'])) {
            throw new \InvalidArgumentException('match_id and team_id are required for foul events');
        }


    }
}
