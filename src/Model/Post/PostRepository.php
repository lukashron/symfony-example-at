<?php declare(strict_types=1);

namespace App\Model\Post;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Post>
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    /**
     * @param int $externalId
     * @return Post|null
     */
    public function findByExternalId(int $externalId): ?Post
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @return int
     */
    public function countForPublicList(): int
    {
        return $this->count([]);
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findForPublicList(int $limit, int $offset): array
    {
        return $this->findBy([], ['id' => 'DESC'], $limit, $offset);
    }
}
