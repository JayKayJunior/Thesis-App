<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $puuid;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $gameName;

    #[ORM\Column(length: 56)]
    private ?string $accountId = null;

    #[ORM\Column(nullable: true)]
    private ?int $profileIconId = null;

    #[ORM\Column(length: 63)]
    private ?string $gameId = null;

    #[ORM\Column(nullable: true)]
    private ?int $summonerLevel = null;

    #[ORM\Column(length: 4)]
    private ?string $serwer = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPuuid(): ?string
    {
        return $this->puuid;
    }

    public function setPuuid(string $puuid): self
    {
        $this->puuid = $puuid;

        return $this;
    }

    public function getGameName(): ?string
    {
        return $this->gameName;
    }

    public function setGameName(?string $gameName): self
    {
        $this->gameName = $gameName;

        return $this;
    }

    public function getAccountId(): ?string
    {
        return $this->accountId;
    }

    public function setAccountId(string $accountId): self
    {
        $this->accountId = $accountId;

        return $this;
    }

    public function getProfileIconId(): ?int
    {
        return $this->profileIconId;
    }

    public function setProfileIconId(?int $profileIconId): self
    {
        $this->profileIconId = $profileIconId;

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

    public function getSummonerLevel(): ?int
    {
        return $this->summonerLevel;
    }

    public function setSummonerLevel(?int $summonerLevel): self
    {
        $this->summonerLevel = $summonerLevel;

        return $this;
    }

    public function getSerwer(): ?string
    {
        return $this->serwer;
    }

    public function setSerwer(string $serwer): self
    {
        $this->serwer = $serwer;

        return $this;
    }
}
