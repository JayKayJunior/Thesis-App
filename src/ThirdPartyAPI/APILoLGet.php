<?php

namespace App\ThirdPartyAPI;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function getLoLAccontByNick(string $nick, string $tagLine, $httpClient)
    {

        $head = $this->getLoLHeaders();
        $response = $httpClient->request('GET', "https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$nick}/{$tagLine}",$head);

        if (200 !== $response->getStatusCode()){
            return (NULL);
        }
        $content = $response->getContent();
        $decode = json_decode($content);
        return ($decode);
        }
    }

    
