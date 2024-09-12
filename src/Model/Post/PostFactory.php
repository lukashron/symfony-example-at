<?php declare(strict_types=1);

namespace App\Model\Post;

use App\Model\Post\Exception\PostFactoryUserNotFoundException;
use App\Model\User\UserRepository;

class PostFactory
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @param PostDto $postDto
     * @return Post
     * @throws PostFactoryUserNotFoundException
     */
    public function makeFromPostDto(PostDto $postDto): Post
    {
        $user = $this->userRepository->findByExternalId(
            $postDto->getAuthorId()
        );

        if (is_null($user)) {
            throw new PostFactoryUserNotFoundException(
                sprintf('User with external id %d not found', $postDto->getAuthorId())
            );
        }

        $post = new Post();
        $post->setExternalId($postDto->getExternalId());
        $post->setTitle($postDto->getTitle());
        $post->setBody($postDto->getBody());
        $post->setAuthor($user);

        return $post;
    }
}
