<?php

namespace App\ThirdPartyAPI;

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
    }

    
