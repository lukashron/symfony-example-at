<?php declare(strict_types=1);

namespace App\Model\Comment;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    /**
     * @param int $externalId
     * @return Comment|null
     */
    public function findByExternalId(int $externalId): ?Comment
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }

    /**
     * @param int $postId
     * @return Comment[] array
     */
    public function findByPostIdForPublicList(int $postId): array
    {
        return $this->findBy(['post' => $postId], ['id' => 'DESC']);
    }
}
