<?php

    namespace App\Repository;

    use App\Entity\ItemTradable;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @extends BaseRepository<ItemTradable>
     *
     * @method ItemTradable|null find($id, $lockMode = null, $lockVersion = null)
     * @method ItemTradable|null findOneBy(array $criteria, array $orderBy = null)
     * @method ItemTradable[]    findAll()
     * @method ItemTradable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    class ItemTradableRepository extends BaseRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, ItemTradable::class);
        }
    }
