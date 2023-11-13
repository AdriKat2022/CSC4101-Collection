<?php

namespace App\Repository;

use App\Entity\HearthstoneCardbook;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HearthstoneCardbook>
 *
 * @method HearthstoneCardbook|null find($id, $lockMode = null, $lockVersion = null)
 * @method HearthstoneCardbook|null findOneBy(array $criteria, array $orderBy = null)
 * @method HearthstoneCardbook[]    findAll()
 * @method HearthstoneCardbook[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HearthstoneCardbookRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HearthstoneCardbook::class);
    }

//    /**
//     * @return HearthstoneCardbook[] Returns an array of HearthstoneCardbook objects
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

    public function remove(HearthstoneCardbook $entity, bool $flush = false): void
    {
        $hthcardRepository = $this->getEntityManager()->getRepository(Hthcard::class);

        // clean the cards properly
        $hthcards = $entity->getCards();

        foreach($hthcards as $hthcard) {
            $hthcardRepository->remove($hthcard, $flush);
        }
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /**
     * Returns the book with the corresponding name
     */
    public function findOneByName($name): ?HearthstoneCardbook
    {
        return $this->createQueryBuilder('book')
            ->andWhere('book.name = :val')
            ->setParameter('val', $name)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Returns the book with the corresponding name
     */
    public function findById($id): ?HearthstoneCardbook
    {
        return $this->createQueryBuilder('book')
            ->andWhere('book.id = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}
