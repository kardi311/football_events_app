<?php

namespace App\Entity;

use App\Repository\FoulEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoulEventRepository::class)]
class FoulEvent
{
    public const EVENT_TYPE = 'foul';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[ORM\OneToOne(targetEntity: Player::class)]
    private ?int $playerId = null;

    #[ORM\Column]
    #[ORM\OneToOne(targetEntity: Team::class)]
    private ?int $teamId = null;

    #[ORM\Column]
    private ?int $minute = null;

    #[ORM\Column]
    private ?int $second = null;

    #[ORM\Column(length: 255)]
    private ?string $matchId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getPlayerId(): ?int
    {
        return $this->playerId;
    }

    public function setPlayerId(int $playerId): static
    {
        $this->playerId = $playerId;

        return $this;
    }

    public function getTeamId(): ?int
    {
        return $this->teamId;
    }

    public function setTeamId(int $teamId): static
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

    public function getSecond(): ?int
    {
        return $this->second;
    }

    public function setSecond(int $second): static
    {
        $this->second = $second;

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
