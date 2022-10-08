<?php

namespace App\ThirdPartyAPI;


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

        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            $content = $response->getContent();
            $decode = json_decode($content);
            return ($decode);
        }
        return ($statusCode);
    }


}
