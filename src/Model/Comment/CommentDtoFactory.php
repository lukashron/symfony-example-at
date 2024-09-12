<?php declare(strict_types=1);

namespace App\Model\Comment;

use App\Api\ApiRequestProcessingTrait;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class CommentDtoFactory
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
     * @return CommentDto[] array
     * @throws \App\Api\Exception\ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makeFromApiResponse(ResponseInterface $response): array
    {
        return $this->deserializeJsonItems($this->serializer, $this->validator, $response, CommentDto::class);
    }

    /**
     * @param Comment $comment
     * @return CommentDto
     */
    public function makeFromEntity(Comment $comment): CommentDto
    {
        $dto = new CommentDto();
        $dto->setId($comment->getId());
        $dto->setExternalId($comment->getExternalId());
        $dto->setPostId($comment->getId());
        $dto->setName($comment->getName());
        $dto->setEmail($comment->getEmail());
        $dto->setBody($comment->getBody());

        return $dto;
    }
}
