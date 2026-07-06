<?php

    namespace App\Repository;

    use App\Entity\RivenAttribute;
    use Doctrine\Persistence\ManagerRegistry;

    /**
     * @extends BaseRepository<RivenAttribute>
     *
     * @method RivenAttribute|null find($id, $lockMode = null, $lockVersion = null)
     * @method RivenAttribute|null findOneBy(array $criteria, array $orderBy = null)
     * @method RivenAttribute[]    findAll()
     * @method RivenAttribute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
     */
    class RivenAttributeRepository extends BaseRepository
    {
        public function __construct(ManagerRegistry $registry)
        {
            parent::__construct($registry, RivenAttribute::class);
        }
    }
