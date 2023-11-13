<?php

namespace App\Repository;

use App\Entity\Hthcard;
use App\Entity\Deck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Deck>
 *
 * @method Deck|null find($id, $lockMode = null, $lockVersion = null)
 * @method Deck|null findOneBy(array $criteria, array $orderBy = null)
 * @method Deck[]    findAll()
 * @method Deck[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DeckRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Deck::class);
    }



    public function remove(Hthcard $hthcard, bool $flush = false): void
    {
        $deckRepository = $this->getEntityManager()->getRepository(Deck::class);

        // get rid of the ManyToMany relation with decks
        $decks = $deckRepository->findCardDeck($hthcard);   

        foreach($decks as $deck) {
            $deck->removeCard($hthcard);
            $this->getEntityManager()->persist($deck);
        }

        if ($flush) {
            $this->getEntityManager()->flush();
        }

        $this->getEntityManager()->remove($hthcard);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Deck[] Returns an array of Deck objects
     */
    public function findCardDeck(Hthcard $hthcard): array
    {
        return $this->createQueryBuilder('g')
            ->leftJoin('g.cards', 'o')
            ->andWhere('o = :hthcard')
            ->setParameter('hthcard', $hthcard)
            ->getQuery()
            ->getResult()
        ;
    }



//    /**
//     * @return Deck[] Returns an array of Deck objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Deck
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
