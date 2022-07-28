<?php

namespace App\Repository;

use App\Entity\Datenow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Datenow>
 *
 * @method Datenow|null find($id, $lockMode = null, $lockVersion = null)
 * @method Datenow|null findOneBy(array $criteria, array $orderBy = null)
 * @method Datenow[]    findAll()
 * @method Datenow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DatenowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Datenow::class);
    }

    public function add(Datenow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Datenow $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return Datenow[] Returns an array of Datenow objects
   */
   public function getDefaultValue(): array
    {
        return $this->createQueryBuilder('d')

            ->orderBy('d.id', 'DESC')
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
        ;
    }

//    public function findOneBySomeField($value): ?Datenow
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/* $qb = $this->createQueryBuilder('a')
            ->leftJoin('a.category', 'c')
            ->where('a.job = :id')
            ->setParameter('id', $id)
            ->addOrderBy('c.rank', 'DESC')
            ->addOrderBy('a.updated', 'DESC')    
            ;

return $query = $qb->getQuery();
 */
}
