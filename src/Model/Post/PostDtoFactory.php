<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Api\ApiRequestProcessingTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class PostDtoFactory
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
     * @return PostDto[] array
     * @throws \App\Api\Exception\ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makeFromApiResponse(ResponseInterface $response): array
    {
        return $this->deserializeJsonItems($this->serializer, $this->validator, $response, PostDto::class);
    }

    /**
     * @param Post $post
     * @return PostDto
     */
    public function makeFromEntity(Post $post): PostDto
    {
        $dto = new PostDto();
        $dto->setId($post->getId());
        $dto->setExternalId($post->getExternalId());
        $dto->setTitle($post->getTitle());
        $dto->setBody($post->getBody());
        $dto->setAuthorId($post->getAuthor()->getId());

        return $dto;
    }
}
