<?php
declare(strict_types=1);

namespace App\Message;

use App\Entity\GoalEvent;
use Symfony\Component\Messenger\Attribute\AsMessage;

#[AsMessage('sync')]
final class GoalEventMessage extends AbstractEventMessage
{
    public function __construct(
        public string $scorer,
        public string $teamId,
        public string $matchId,
        public int $minute,
        public string $assistingPlayer
    )
    {
        parent::__construct(GoalEvent::EVENT_TYPE);
    }

    public static function fromPayload(array $payload): self
    {
        return new self(
            $payload['scorer'],
            $payload['team_id'],
            $payload['match_id'],
            $payload['minute'],
            $payload['assisting_player']
        );
    }
}
