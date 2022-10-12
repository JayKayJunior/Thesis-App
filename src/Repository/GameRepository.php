<?php

namespace App\Repository;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @extends ServiceEntityRepository<Game>
 *
 * @method Game|null find($id, $lockMode = null, $lockVersion = null)
 * @method Game|null findOneBy(array $criteria, array $orderBy = null)
 * @method Game[]    findAll()
 * @method Game[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        parent::__construct($registry, Game::class);
        $this->em = $em;
    }

    public function add(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Game $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getHistoryGame($matchId,$httpClient): Game
    {
        $array = $this->createQueryBuilder('m')
            ->andWhere('m.matchId = :matchId')
            ->setParameter('matchId', $matchId)
            ->setMaxResults(1)
            ->getQuery()
           ->getResult();

        if($array == []) {
            $game = new Game();
            $game->setMatchId($matchId);
            (new \App\ThirdPartyAPI\APILoLGet)->getHistoryMath($game, $httpClient);
            if ($game->getParticipants() == []) {
                return $game;
            }else{
                $timeH = gmdate("h", $game->getGameDuration());
                if($timeH == 12){
                    $game->setGameDuration(gmdate("i:s", $game->getGameDuration()));
                }else{
                    $game->setGameDuration(gmdate("h:i:s", $game->getGameDuration()));
                }
                $arrayTeamBlue = [];
                $arrayTeamRed = [];
                foreach ($game->getParticipants() as $parcipiant) {
                    if($parcipiant->championName == 'FiddleSticks'){
                        $parcipiant->championName = 'Fiddlesticks';
                    }
                    if ($parcipiant->teamId == 100){
                        $arrayTeamBlue[]=$parcipiant;
                    }else{
                        $arrayTeamRed[]=$parcipiant;
                    }
                }
                $array[] = $arrayTeamBlue;
                $array[] = $arrayTeamRed;
                $game->setParticipants($array);



                $teams = $game->getTeams();
                if(!(isset($teams[1]->teamId))){
                    if($teams[0]->teamId == 100){
                        $arrayRedT = array("bans"=>[],
                            "objectives"=>[
                                "baron"=>["first"=>false, "kills"=>0],
                                "champion"=>["first"=>false,"kills"=>0],
                                "dragon"=>["first"=>false, "kills"=>0],
                                "inhibitor"=>["first"=>false,"kills"=>0],
                                "riftHerald"=>["first"=>false,"kills"=>0],
                                "tower"=>["first"=>false, "kills"=>0]
                            ],
                            "teamId"=>200,
                            "win"=>false);
                        $teams[] = $arrayRedT;
                        $game->setTeams($teams);
                    }else{
                        $arrayRedT = $teams[0];
                        $arrayBlueT = array("bans"=>[],
                            "objectives"=>[
                                "baron"=>["first"=>false, "kills"=>0],
                                "champion"=>["first"=>false,"kills"=>0],
                                "dragon"=>["first"=>false, "kills"=>0],
                                "inhibitor"=>["first"=>false,"kills"=>0],
                                "riftHerald"=>["first"=>false,"kills"=>0],
                                "tower"=>["first"=>false, "kills"=>0]
                            ],
                            "teamId"=>100,
                            "win"=>false);
                        $newTeams[] = $arrayBlueT;
                        $newTeams[] = $arrayRedT;
                        $game->setTeams($newTeams);
                    }
                }

                $this->em->persist($game);
                $this->em->flush();
            }
        }else{
            $game = $array[0];
        }
        return $game;
    }
//    /**
//     * @return Game[] Returns an array of Game objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('g.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Game
//    {
//        return $this->createQueryBuilder('g')
//            ->andWhere('g.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
