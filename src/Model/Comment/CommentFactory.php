<?php declare(strict_types=1);

namespace App\Model\Comment;

use App\Model\Comment\Exception\CommentFactoryPostNotFoundException;
use App\Model\Post\PostRepository;

class CommentFactory
{
    public function __construct(
        private readonly PostRepository $postRepository
    )
    {

    }

    /**
     * @param CommentDto $commentDto
     * @return Comment
     * @throws CommentFactoryPostNotFoundException
     */
    public function makeFromCommentDto(CommentDto $commentDto): Comment
    {
        $post = $this->postRepository->findByExternalId(
            $commentDto->getPostId()
        );

        if (is_null($post)) {
            throw new CommentFactoryPostNotFoundException(
                sprintf('Post with external id %d not found', $commentDto->getPostId())
            );
        }

        $comment = new Comment();
        $comment->setExternalId($commentDto->getExternalId());
        $comment->setPost($post);
        $comment->setName($commentDto->getName());
        $comment->setEmail($commentDto->getEmail());
        $comment->setBody($commentDto->getBody());

        return $comment;
    }
}
