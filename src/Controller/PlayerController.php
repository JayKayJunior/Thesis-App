<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Player;


class PlayerController extends AbstractController
{

    #[Route('/player/{tagLine}/{gameName}', name: 'app_player',methods:['GET','HEAD'])]
    public function index($tagLine,$gameName,HttpClientInterface $httpClient): Response
    {
        $player = new Player();
        $player->setGameName($gameName);
        $player->setTagLine($tagLine);

        (new \App\ThirdPartyAPI\APILoLGet)->getLoLAccontByNick($player, $httpClient);

        if ($player->getPuuid() == NULL) {
            return $this->render('player/player_not_found.html.twig', [
                'gameName' => $player->getGameName(),
                'tagLine' => $player->getTagLine(),
            ]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($player);
        $entityManager->flush();


        return $this->render('player/player.html.twig', [
            'gameName' => $player->getGameName(),
            'tagLine' => $player->getTagLine(),
            'puuid' => $player->getPuuid() ,
        ]);
    }

}


