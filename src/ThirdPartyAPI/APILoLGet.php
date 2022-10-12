<?php

namespace App\ThirdPartyAPI;

use App\Entity\Game;
use App\Entity\Player;

class APILoLGet
{
    public function getLoLHeaders()
    {
        $headers = ['headers' => [
            "Accept-Language"=> "pl",
            "Accept-Charset"=> "application/x-www-form-urlencoded; charset=UTF-8",
            "Origin"=>"https://developer.riotgames.com",
            "X-Riot-Token"=> $_ENV['X_Riot_Token_API']],
        ];
        return ($headers);

    }

    public function getLoLAccontBySummonerName(player $player, $httpClient)
    {

        $response = $httpClient->request('GET', "https://{$player->getSerwer()}.api.riotgames.com/lol/summoner/v4/summoners/by-name/{$player->getGameName()}",$this->getLoLHeaders());
        if (200 !== $response->getStatusCode()){
            return ($player);
        }
        $content = $response->getContent();
        $decode = json_decode($content);

        $player->setSerwer($player->getSerwer());
        $player->setPuuid($decode->puuid);
        $player->setAccountId($decode->accountId);
        $player->setProfileIconId($decode->profileIconId);
        $player->setGameName($decode->name);
        $player->setGameId($decode->id);
        $player->setSummonerLevel($decode->summonerLevel);

        return ($player);
    }

    public function getLoLAccontByNick(player $player, $httpClient)
    {
        $response = $httpClient->request('GET', "https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$player->getGameName()}/{$player->getTagLine()}",$this->getLoLHeaders());
        if (200 !== $response->getStatusCode()){
            return ($player);
        }
        $content = $response->getContent();
        $decode = json_decode($content);
        $player->setPuuid($decode->puuid);
        return ($player);
    }

    public function getHistoryPlayerGames(player $player, $httpClient, $to, $many)
    {
        $response = $httpClient->request('GET', "https://europe.api.riotgames.com/lol/match/v5/matches/by-puuid/{$player->getPuuid()}/ids?start={$to}&count={$many}",$this->getLoLHeaders());
        if (200 !== $response->getStatusCode()){
            return ([]);
        }
        $content = $response->getContent();
        $decode = json_decode($content);
        return ($decode);
    }

    public function getHistoryMath(Game $game, $httpClient)
    {
        $response = $httpClient->request('GET', "https://europe.api.riotgames.com/lol/match/v5/matches/{$game->getMatchId()}",$this->getLoLHeaders());
        if (200 !== $response->getStatusCode()){
            return ([]);
        }
        $content = $response->getContent();
        $decode = json_decode($content);

        $game->setGameCreation($decode->info->gameCreation);
        $game->setParticipants($decode->info->participants);
        $game->setGameDuration($decode->info->gameDuration);
        $game->setGameId($decode->info->gameId);
        $game->setGameMode($decode->info->gameMode);
        $game->setGameType($decode->info->gameType);
        $game->setGameVersion($decode->info->gameVersion);
        $game->setMapId($decode->info->mapId);
        $game->setPlatformId($decode->info->platformId);
        $game->setQueueId($decode->info->queueId);
        $game->setTeams($decode->info->teams);
        $game->setTournamentCode($decode->info->tournamentCode);

        return ($game);
    }


    public function getRangPlayer(Player $player, $httpClient)
    {
        $response = $httpClient->request('GET', "https://eun1.api.riotgames.com/lol/league/v4/entries/by-summoner/{$player->getGameId()}",$this->getLoLHeaders());
        if (200 !== $response->getStatusCode()){
            return ([]);
        }
        $content = $response->getContent();
        $rangs = json_decode($content);

        return ($rangs);
    }

}

    
