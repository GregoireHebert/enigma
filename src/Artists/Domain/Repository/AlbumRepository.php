<?php

namespace App\Artists\Domain\Repository;

use App\Artists\Domain\Entity\Album;
use App\Artists\Domain\Entity\Artist;
use App\Customers\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Album>
 *
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Album::class);
    }

    public function save(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Album $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @return iterable<Album>
     */
    public function findAllForUserArtist(User $user): iterable
    {
        $artists = $user->getArtists();
        $ids = array_map(fn (Artist $artist) => $artist->getId(), $artists->toArray());

        $qb = $this->createQueryBuilder('a');
        return $qb
            ->andWhere($qb->expr()->in('a.artist', $ids))
            ->orderBy('a.name', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
}
