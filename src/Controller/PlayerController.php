<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;





class PlayerController extends AbstractController
{
    #[Route('/player/{tagLine}/{nick}', name: 'app_player',methods:['GET','HEAD'])]
    public function index($tagLine,$nick,HttpClientInterface $httpClient): Response
    {

        $response = $httpClient->request('GET', "https://europe.api.riotgames.com/riot/account/v1/accounts/by-riot-id/{$nick}/{$tagLine}",[
            'headers' => [
                "Accept-Language"=> "pl",
                "Accept-Charset"=> "application/x-www-form-urlencoded; charset=UTF-8",
                "Origin"=>"https://developer.riotgames.com",
                "X-Riot-Token"=> "RGAPI-e6496e1c-7957-427d-9ead-cdb0b82358fc"
    ],       ]);


        $content = $response->getContent();
        $decode = json_decode($content);

        return $this->render('player/index.html.twig', [
            'nick' => $nick,
            'tagLine'=> $tagLine,
            'puuid' => $decode->puuid,

            'controller_name' => 'PlayerController',
        ]);
    }
}
