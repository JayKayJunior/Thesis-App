<?php

namespace App\Repository;

use App\Entity\Player;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @extends ServiceEntityRepository<Player>
 *
 * @method Player|null find($id, $lockMode = null, $lockVersion = null)
 * @method Player|null findOneBy(array $criteria, array $orderBy = null)
 * @method Player[]    findAll()
 * @method Player[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayerRepository extends ServiceEntityRepository
{
    private $em;

    public function __construct(ManagerRegistry $registry,EntityManagerInterface $em)
    {
        parent::__construct($registry, Player::class);
        $this->em = $em;
    }

    public function add(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Player $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

   /**
    * @return Player[] Returns an array of Player objects
    */
    public function findByPuuid($puuid): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.puuid = :puuid')
            ->setParameter('puuid', $puuid)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByGameName($gameName,$serwer,$httpClient): Player
    {
        $array = $this->createQueryBuilder('p')
            ->andWhere('p.gameName = :gameName')
            ->setParameter('gameName', $gameName)
            ->andWhere('p.serwer = :serwer')
            ->setParameter('serwer', $serwer)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult();

        if($array == []) {
            $player = new Player();
            $player->setGameName($gameName);
            $player->setSerwer($serwer);

        }else{
            $player = $array[0];
        }
        (new \App\ThirdPartyAPI\APILoLGet)->getLoLAccontBySummonerName($player,$httpClient);
        if ($player->getPuuid() == NULL) {
            return $player;
        }else{
            $this->em->persist($player);
            $this->em->flush();
        }
        return $player;
    }

//    public function findOneBySomeField($value): ?Player
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
