<?php

namespace App\Repository;

use App\Entity\Gift;
use App\Entity\GiftSearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gift|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gift|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gift[]    findAll()
 * @method Gift[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GiftRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gift::class);
    }

    public function findGift(GiftSearch $giftSearch): array
    {
        $queryBuilder = $this->createQueryBuilder('g');
        if ($giftSearch->getInput()) {
            $queryBuilder->
            andWhere('g.name LIKE :name')
                ->setParameter('name', '%' . $giftSearch->getInput() . '%')
                ->orWhere('g.metaphone = :metaphone')
                ->setParameter('metaphone', metaphone($giftSearch->getInput() ?? ''));
        }
        if ($giftSearch->getCategory() !== null) {
            $queryBuilder->
            andWhere('g.category = :category')
                ->setParameter('category', $giftSearch->getCategory());
        }

        return $queryBuilder->getQuery()->getResult();
    }
}
