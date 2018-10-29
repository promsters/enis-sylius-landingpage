<?php

namespace Enis\SyliusLandingPagePlugin\Repository;

use Enis\SyliusLandingPagePlugin\Entity\LandingPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method LandingPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method LandingPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method LandingPage[]    findAll()
 * @method LandingPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LandingPageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, LandingPage::class);
    }

    public function getActiveById($id)
    {
        $qb = $this->createQueryBuilder('l');
        return $qb->select('l.template')
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('l.starts_at'),
                    $qb->expr()->lt('l.starts_at', 'CURRENT_TIMESTAMP()')
                ),
                $qb->expr()->isNull('l.starts_at')
            ))
            ->andWhere($qb->expr()->orX(
                $qb->expr()->andX(
                    $qb->expr()->isNotNull('l.ends_at'),
                    $qb->expr()->gt('l.ends_at', 'CURRENT_TIMESTAMP()')
                ),
                $qb->expr()->isNull('l.ends_at')
            ))
            ->andWhere($qb->expr()->eq('l.id', $id))
            ->getQuery()
            ->getResult()
        ;
    }
}
