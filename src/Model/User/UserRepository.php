<?php declare(strict_types=1);

namespace App\Model\User;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $externalId
     * @return User|null
     */
    public function findByExternalId(int $externalId): ?User
    {
        return $this->findOneBy(['externalId' => $externalId]);
    }
}
