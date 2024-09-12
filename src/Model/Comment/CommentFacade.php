<?php declare(strict_types=1);

namespace App\Model\Comment;

use Doctrine\ORM\EntityManagerInterface;

class CommentFacade
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly CommentFactory $commentFactory,
        private readonly CommentRepository $commentRepository,
        private readonly CommentDtoFactory $commentDtoFactory
    )
    {
    }

    /**
     * @param int $postId
     * @return CommentDto[] array
     */
    public function findByPostIdForPublicList(int $postId): array
    {
        $comments = $this->commentRepository->findByPostIdForPublicList($postId);

        $dtos = [];
        foreach ($comments as $comment) {
            $dtos[] = $this->commentDtoFactory->makeFromEntity($comment);
        }

        return $dtos;
    }

    /**
     * @param CommentDto $commentDto
     * @param bool $skipDuplicateExternalId
     * @return Comment
     * @throws Exception\CommentFactoryPostNotFoundException
     */
    public function createFromCommentDto(CommentDto $commentDto, bool $skipDuplicateExternalId = true): Comment
    {
        $comment = $this->commentFactory->makeFromCommentDto($commentDto);

        if ($skipDuplicateExternalId) {
            $existComment = $this->commentRepository->findByExternalId(
                $comment->getExternalId()
            );

            if (!is_null($existComment)) {
                return $existComment;
            }
        }

        return $this->save($comment);
    }

    /**
     * @param Comment $comment
     * @return Comment
     */
    public function save(Comment $comment): Comment
    {
        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return $comment;
    }
}
