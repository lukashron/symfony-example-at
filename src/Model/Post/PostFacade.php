<?php declare(strict_types=1);

namespace App\Model\Post;

use Doctrine\ORM\EntityManagerInterface;

class PostFacade
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly PostFactory $postFactory,
        private readonly PostRepository $postRepository,
        private readonly PostDtoFactory $postDtoFactory
    )
    {
    }

    /**
     * @param int $id
     * @return PostDto|null
     */
    public function findByIdForPublicShow(int $id): ?PostDto
    {
        $post = $this->postRepository->find($id);

        if (is_null($post)) {
            return null;
        }

        return $this->postDtoFactory->makeFromEntity($post);
    }

    /**
     * @return int
     */
    public function countForPublicList(): int
    {
        return $this->postRepository->countForPublicList();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function findAllForPublicList(int $limit, int $offset): array
    {
        $dtos = [];
        foreach ($this->postRepository->findForPublicList($limit, $offset) as $post) {
            $dtos[] = $this->postDtoFactory->makeFromEntity($post);
        }

        return $dtos;
    }

    /**
     * @param PostDto $dto
     * @param bool $skipDuplicateExternalId
     * @return Post
     * @throws Exception\PostFactoryUserNotFoundException
     */
    public function createFromPostDto(PostDto $dto, bool $skipDuplicateExternalId = true): Post
    {
        $post = $this->postFactory->makeFromPostDto($dto);

        if ($skipDuplicateExternalId) {
            $existPost = $this->postRepository->findByExternalId(
                $post->getExternalId()
            );

            if (!is_null($existPost)) {
                return $existPost;
            }
        }

        return $this->save($post);
    }

    /**
     * @param Post $post
     * @return Post
     */
    public function save(Post $post): Post
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $post;
    }
}
