<?php

namespace App\Repository;

use App\Entity\Preguntas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Preguntas>
 *
 * @method Preguntas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Preguntas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Preguntas[]    findAll()
 * @method Preguntas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PreguntasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Preguntas::class);
    }

    public function add(Preguntas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Preguntas $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findOneByid($value): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.productos_id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }

    //    /**
//     * @return Preguntas[] Returns an array of Preguntas objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }
    public function borrar($value): ?Preguntas
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
}