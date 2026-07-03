<?php

    namespace App\Repository;

    use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
    use Doctrine\Persistence\ManagerRegistry;

    abstract class BaseRepository extends ServiceEntityRepository
    {
        public function __construct(ManagerRegistry $registry, string $entity)
        {
            parent::__construct($registry, $entity);
        }


        public function getList ($cond): array
        {
            return $this->findBy($cond);
        }

        public function getSingle($cond){
            return $this->findOneBy($cond);
        }
    }
