<?php declare(strict_types=1);

namespace App\Model\User;

class UserFactory
{
    /**
     * @param UserDto $userDto
     * @return User
     */
    public function makeFromUserDto(UserDto $userDto): User
    {
        $user = new User();
        $user->setExternalId($userDto->getExternalId());
        $user->setName($userDto->getName());
        $user->setUsername($userDto->getUsername());
        $user->setEmail($userDto->getEmail());
        $user->setPhone($userDto->getPhone());
        $user->setWebsite($userDto->getWebsite());

        return $user;
    }
}
