<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\GoalEventRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Ignore;

#[ORM\Entity(repositoryClass: GoalEventRepository::class)]
class GoalEvent
{
    public const EVENT_TYPE = 'goal';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $scorer = null;

    #[ORM\Column(length: 255)]
    private ?string $assistingPlayer = null;

    #[ORM\Column(length: 255)]
    private ?string $teamId = null;

    #[ORM\Column]
    private ?int $minute = null;

    #[ORM\Column(length: 255)]
    private ?string $matchId = null;

    #[Ignore]
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getScorer(): ?string
    {
        return $this->scorer;
    }

    public function setScorer(string $scorer): static
    {
        $this->scorer = $scorer;

        return $this;
    }

    public function getAssistingPlayer(): ?string
    {
        return $this->assistingPlayer;
    }

    public function setAssistingPlayer(string $assisting_player): static
    {
        $this->assistingPlayer = $assisting_player;

        return $this;
    }

    public function getTeamId(): ?string
    {
        return $this->teamId;
    }

    public function setTeamId(string $teamId): static
    {
        $this->teamId = $teamId;

        return $this;
    }

    public function getMinute(): ?int
    {
        return $this->minute;
    }

    public function setMinute(int $minute): static
    {
        $this->minute = $minute;

        return $this;
    }

    public function getMatchId(): ?string
    {
        return $this->matchId;
    }

    public function setMatchId(string $matchId): static
    {
        $this->matchId = $matchId;

        return $this;
    }
}
