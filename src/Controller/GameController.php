<?php

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GameController extends AbstractController
{

    private $gameRepository;
    public function __construct(gameRepository $gameRepository){
        $this->gameRepository = $gameRepository;
    }


    #[Route('/game/{matchId}', name: 'app_game')]
    public function index($matchId,HttpClientInterface $httpClient): Response
    {
        $game = $this->gameRepository->getHistoryGame($matchId,$httpClient);
        if($game->getParticipants() == []){
            return $this->render('game/game_not_found.html.twig', [
                'game' => $game,
            ]);
        }
        $str = $game->getMatchId();
        $pattern = '/(?<serwer>.*?)_/';
        preg_match($pattern, $str,$serwer);

        return $this->render('game/game.html.twig', [
            'serwer' => $serwer['serwer'],
            'game' => $game,
        ]);
    }
}
