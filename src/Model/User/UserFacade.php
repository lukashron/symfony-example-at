<?php declare(strict_types=1);

namespace App\Model\User;

use Doctrine\ORM\EntityManagerInterface;

class UserFacade
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly UserFactory $userFactory,
        private readonly UserRepository $userRepository,
        private readonly UserDtoFactory $userDtoFactory
    )
    {
    }

    /**
     * @param int $id
     * @return UserDto|null
     */
    public function findByIdForPublicShow(int $id): ?UserDto
    {
        $user = $this->userRepository->find($id);

        if (is_null($user)) {
            return null;
        }

        return $this->userDtoFactory->makeFromEntity($user);
    }

    /**
     * @param UserDto $dto
     * @param bool $skipDuplicateExternalId
     * @return User
     */
    public function createFromUserDto(UserDto $dto, bool $skipDuplicateExternalId = true): User
    {
        $user = $this->userFactory->makeFromUserDto($dto);

        if ($skipDuplicateExternalId) {
            $existUser = $this->userRepository->findByExternalId(
                $user->getExternalId()
            );

            if (!is_null($existUser)) {
                return $existUser;
            }
        }

        return $this->save($user);
    }

    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }
}
