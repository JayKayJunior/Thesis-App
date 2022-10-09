<?php

namespace App\Entity;

use App\Repository\GameRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameRepository::class)]
class Game
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(length: 255)]
    private ?string $matchId = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $participants = [];

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $gameCreation = null;

    #[ORM\Column]
    private ?int $gameDuration = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $gameEndTimestamp = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $gameId = null;

    #[ORM\Column(length: 255)]
    private ?string $gameMode = null;

    #[ORM\Column(length: 255)]
    private ?string $gameType = null;

    #[ORM\Column(length: 255)]
    private ?string $gameVersion = null;

    #[ORM\Column]
    private ?int $mapId = null;

    #[ORM\Column(length: 255)]
    private ?string $platformId = null;

    #[ORM\Column]
    private ?int $queueId = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $teams = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tournamentCode = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatchId(): ?string
    {
        return $this->matchId;
    }

    public function setMatchId(string $matchId): self
    {
        $this->matchId = $matchId;

        return $this;
    }

    public function getParticipants(): array
    {
        return $this->participants;
    }

    public function setParticipants(array $participants): self
    {
        $this->participants = $participants;

        return $this;
    }

    public function getGameCreation(): ?string
    {
        return $this->gameCreation;
    }

    public function setGameCreation(string $gameCreation): self
    {
        $this->gameCreation = $gameCreation;

        return $this;
    }

    public function getGameDuration(): ?int
    {
        return $this->gameDuration;
    }

    public function setGameDuration(int $gameDuration): self
    {
        $this->gameDuration = $gameDuration;

        return $this;
    }

    public function getGameEndTimestamp(): ?string
    {
        return $this->gameEndTimestamp;
    }

    public function setGameEndTimestamp(string $gameEndTimestamp): self
    {
        $this->gameEndTimestamp = $gameEndTimestamp;

        return $this;
    }

    public function getGameId(): ?string
    {
        return $this->gameId;
    }

    public function setGameId(string $gameId): self
    {
        $this->gameId = $gameId;

        return $this;
    }

    public function getGameMode(): ?string
    {
        return $this->gameMode;
    }

    public function setGameMode(string $gameMode): self
    {
        $this->gameMode = $gameMode;

        return $this;
    }

    public function getGameType(): ?string
    {
        return $this->gameType;
    }

    public function setGameType(string $gameType): self
    {
        $this->gameType = $gameType;

        return $this;
    }

    public function getGameVersion(): ?string
    {
        return $this->gameVersion;
    }

    public function setGameVersion(string $gameVersion): self
    {
        $this->gameVersion = $gameVersion;

        return $this;
    }

    public function getMapId(): ?int
    {
        return $this->mapId;
    }

    public function setMapId(int $mapId): self
    {
        $this->mapId = $mapId;

        return $this;
    }

    public function getPlatformId(): ?string
    {
        return $this->platformId;
    }

    public function setPlatformId(string $platformId): self
    {
        $this->platformId = $platformId;

        return $this;
    }

    public function getQueueId(): ?int
    {
        return $this->queueId;
    }

    public function setQueueId(int $queueId): self
    {
        $this->queueId = $queueId;

        return $this;
    }

    public function getTeams(): array
    {
        return $this->teams;
    }

    public function setTeams(array $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getTournamentCode(): ?string
    {
        return $this->tournamentCode;
    }

    public function setTournamentCode(?string $tournamentCode): self
    {
        $this->tournamentCode = $tournamentCode;

        return $this;
    }
}
