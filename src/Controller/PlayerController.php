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
    $decodeJson = (new \App\ThirdPartyAPI\APILoLGet)->getLoLAccontByNick($nick, $tagLine,$httpClient);
     if(is_int($decodeJson)) {
         return $this->render('player/player_not_found.html.twig', [
             'nick' => $nick,
             'tagLine' => $tagLine,


             'controller_name' => 'PlayerController',
         ]);
     }
        return $this->render('player/player.html.twig', [
            'nick' => $nick,
            'tagLine' => $tagLine,
            'puuid' => $decodeJson->puuid,

            'controller_name' => 'PlayerController',
        ]);
    }

}


