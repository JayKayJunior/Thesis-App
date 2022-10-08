<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Player;
use App\Database\DatabaseBroker;
use App\Repository\PlayerRepository;
use Doctrine\Persistence\ManagerRegistry;


class PlayerController extends AbstractController
{
    private $em;
    private $playerRepository;

    public function __construct(playerRepository $playerRepository, EntityManagerInterface $em){
        $this->playerRepository = $playerRepository;
        $this->em = $em;

    }
    #[Route('/player/{tagLine}/{gameName}', name: 'app_player',methods:['GET','HEAD'])]
    public function index($tagLine,$gameName,HttpClientInterface $httpClient): Response
    {
        $array = $this->playerRepository->findByGameName($gameName,$tagLine);
        if($array == []) {
            $player = new Player();
            $player->setGameName($gameName);
            $player->setTagLine($tagLine);
            (new \App\ThirdPartyAPI\APILoLGet)->getLoLAccontByNick($player, $httpClient);
            if ($player->getPuuid() == NULL) {
                return $this->render('player/player_not_found.html.twig', [
                    'gameName' => $player->getGameName(),
                    'tagLine' => $player->getTagLine(),
                ]);
            }else{
                $this->em->persist($player);
                $this->em->flush();
            }
        }else{
            $player = $array[0];
        }





        return $this->render('player/player.html.twig', [
            'gameName' => $player->getGameName(),
            'tagLine' => $player->getTagLine(),
            'puuid' => $player->getPuuid() ,
        ]);
    }

}


