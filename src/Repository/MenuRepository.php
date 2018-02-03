<?php

namespace App\Repository;

use App\Entity\Menu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class MenuRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Menu::class);
    }

    
    public function findByName($name)
    {
        return $this->createQueryBuilder('m')
            ->where('m.name = :name')->setParameter('name', $name)
            ->leftJoin('m.links', 'links')
            ->addSelect('links')
            ->getQuery()
            ->getSingleResult()
        ;
    }
    
}
