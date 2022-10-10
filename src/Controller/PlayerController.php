<?php
namespace App\Controller;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Entity\Player;
use App\Entity\Game;
use App\Repository\PlayerRepository;
use App\Repository\GameRepository;
use Doctrine\Persistence\ManagerRegistry;


class PlayerController extends AbstractController
{
    private $playerRepository;
    private $gameRepository;


    public function __construct(playerRepository $playerRepository,gameRepository $gameRepository){
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }
    #[Route('/player/{tagLine}/{gameName}', name: 'app_player',methods:['GET','HEAD'])]
    public function index($tagLine, $gameName, HttpClientInterface $httpClient): Response
    {
        $player = $this->playerRepository->findByGameName($gameName,$tagLine,$httpClient);

        if ($player->getPuuid() == NULL) {
            return $this->render('player/player_not_found.html.twig', [
                'player' => $player,

            ]);
        }


        $historyGame = (new \App\ThirdPartyAPI\APILoLGet)->getHistoryPlayerGames($player, $httpClient);
        $arrayHistoryGames = [];
        foreach ($historyGame as $matchId){
            $game = $this->gameRepository->getHistoryGame($matchId,$httpClient);
            $arrayHistoryGames[] = $game;
        }

        return $this->render('player/player.html.twig', [
            'player' => $player,
            'history_games'=> $arrayHistoryGames,
        ]);
    }

}


