<?php declare(strict_types=1);

namespace App\Model\User;

use App\Api\ApiRequestProcessingTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class UserDtoFactory
{
    use ApiRequestProcessingTrait;

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    )
    {
    }

    /**
     * @param ResponseInterface $response
     * @return UserDto[]
     * @throws \App\Api\Exception\ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makeFromApiResponse(ResponseInterface $response): array
    {
        return $this->deserializeJsonItems($this->serializer, $this->validator, $response, UserDto::class);
    }

    /**
     * @param User $user
     * @return UserDto
     */
    public function makeFromEntity(User $user): UserDto
    {
        $dto = new UserDto();
        $dto->setId($user->getId());
        $dto->setExternalId($user->getExternalId());
        $dto->setName($user->getName());
        $dto->setEmail($user->getEmail());
        $dto->setUsername($user->getUsername());
        $dto->setPhone($user->getPhone());
        $dto->setWebsite($user->getWebsite());

        return $dto;
    }
}
