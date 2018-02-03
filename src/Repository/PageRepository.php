<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class PageRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Page::class);
    }

    
    public function findBySlug($slug)
    {
        return $this->createQueryBuilder('p')
            ->where('p.slug = :slug')->setParameter('slug', $value)
            ->orderBy('p.id', 'ASC')
            ->leftJoin('p.author', 'author')
            ->addSelect('author')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findLast() {
        return $this->createQueryBuilder('p')
            ->orderBy('p.dateCreate', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }
}
