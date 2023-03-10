<?php

namespace App\Repository;

use App\Entity\Productos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Productos>
 *
 * @method Productos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Productos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Productos[]    findAll()
 * @method Productos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductosRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Productos::class);
    }

    public function add(Productos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Productos $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
    public function findByName($name)
    {
        return $this->createQueryBuilder('p')
            ->where('p.nombre_prod LIKE :nombre')
            ->setParameter('nombre', '%'.$name.'%')
            ->getQuery()
            ->getResult();
    }
    
    public function findByOnSale(): array
    {
        // Crea una consulta para recuperar productos que tienen una oferta mayor a cero
        $query = $this->createQueryBuilder('p')
        ->where('p.descuento > 0')
     ->setMaxResults(8) 
        ->getQuery();

        // Ejecuta la consulta y retorna los resultados
        return $query->getResult();
    }
    

    /**
     * @return Productos[] Returns an array of Productos objects
**/
   public function findByExampleField($value)
   {
        return $this->createQueryBuilder('p')
           ->andWhere('p.nombre LIKE :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery();
    }

    public function findOneByid($value): Productos
    {
        return $this->createQueryBuilder('p')
        ->andWhere('p.id = :val')
        ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
   }

   public function findOneMaxID($value)
   {
        return $this->createQueryBuilder('p')
        ->select('MAX(p.id)')
        ->getQuery()
        ->getOneOrNullResult()
;
  }
}
