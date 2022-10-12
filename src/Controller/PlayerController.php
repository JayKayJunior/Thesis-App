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
use App\Controller\HistoryController;
use Doctrine\Persistence\ManagerRegistry;


class PlayerController extends AbstractController
{
    private $playerRepository;
    private $gameRepository;
    private $historyControler;



    public function __construct(playerRepository $playerRepository,gameRepository $gameRepository){
        $this->playerRepository = $playerRepository;
        $this->gameRepository = $gameRepository;
    }

    public function HistoryGames(Player $player ,HttpClientInterface $httpClient, $to, $many){

        $historyGame = (new \App\ThirdPartyAPI\APILoLGet)->getHistoryPlayerGames($player, $httpClient, $to, $many);
        $arrayHistoryGames = [];
        foreach ($historyGame as $matchId){
            $game = $this->gameRepository->getHistoryGame($matchId,$httpClient);
            $arrayHistoryGames[] = $game;
        }
        return $arrayHistoryGames;
    }


    public function getPlayer($gameName,$serwer,HttpClientInterface $httpClient){

        $player = $this->playerRepository->findByGameName($gameName,$serwer,$httpClient);

        if ($player->getPuuid() == NULL) {
            return $this->render('player/player_not_found.html.twig', [
                'player' => $player,

            ]);
        }
            return  $player;
        }



    #[Route('/player/{serwer}/{gameName}', name: 'app_player',methods:['GET','HEAD'])]
    public function player($serwer, $gameName, HttpClientInterface $httpClient): Response
    {
        $player = $this->getPlayer($gameName,$serwer, $httpClient);

        $historyGames = $this->historyGames($player, $httpClient, 0 ,3);

        $rangsPlayer = (new \App\ThirdPartyAPI\APILoLGet)->getRangPlayer($player, $httpClient);
        foreach ($rangsPlayer as $typeGame) {
            $procentWin = (round(($typeGame->wins / ($typeGame->wins + $typeGame->losses)) * 100, 2) . "%");
            $typeGame->procentWin = $procentWin;
        }

        return $this->render('player/player_found.html.twig', [
            'player' => $player,
            'history_games' => $historyGames,
            'rangsPlayer' => $rangsPlayer,
        ]);

    }



    #[Route('player/{serwer}/{gameName}/history', name: 'app_history')]
    #[Route('player/{serwer}/{gameName}/history/{to}/{many}', name: 'app_historycal')]
    public function history($serwer, $gameName, HttpClientInterface $httpClient, $to = 0, $many = 10): Response
    {
        $player = $this->getPlayer($gameName,$serwer, $httpClient);

        $historyGames = $this->historyGames($player, $httpClient, $to, $many);
        dd($historyGames);
        return $this->render('history/history.html.twig', [
            'player' => $player,
            'history_games' => $historyGames,
            'to' => $to,
        ]);
    }
}



