<?php

namespace App\Repository;

use App\Entity\Hthcard;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Hthcard>
 *
 * @method Hthcard|null find($id, $lockMode = null, $lockVersion = null)
 * @method Hthcard|null findOneBy(array $criteria, array $orderBy = null)
 * @method Hthcard[]    findAll()
 * @method Hthcard[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HthcardRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Hthcard::class);
    }

//    /**
//     * @return Hthcard[] Returns an array of Hthcard objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Hthcard
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * Returns the card with the corresponding id
     */
    public function findById($id): ?Hthcard
    {
        return $this->createQueryBuilder('card')
            ->andWhere('card.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
