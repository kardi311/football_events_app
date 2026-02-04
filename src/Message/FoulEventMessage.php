<?php

namespace App\Message;

use App\Entity\FoulEvent;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('sync')]
final class FoulEventMessage extends AbstractEventMessage
{
    public function __construct(
        public string $player,
        public string $teamId,
        public string $matchId,
        public int $minute,
        public int $second
    ) {
        parent::__construct(FoulEvent::EVENT_TYPE);
    }

    /**
     * @param mixed[] $payload
     * @return self
     */
    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['player'],
            $payload['team_id'],
            $payload['match_id'],
            $payload['minute'],
            $payload['second']
        );
    }
}
