<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\Comment\CommentFacade;
use App\Model\Post\PostFacade;
use App\Model\User\UserFacade;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PostShowController extends AbstractController
{
    /**
     * @param PostFacade $postFacade
     * @param UserFacade $userFacade
     * @param CommentFacade $commentFacade
     * @param int $id
     * @return Response
     */
    #[Route('/post/{id}', name: 'app_post_show', requirements: ['id' => '\d+'])]
    public function index(
        PostFacade $postFacade,
        UserFacade $userFacade,
        CommentFacade $commentFacade,
        int $id
    ): Response
    {
        $post = $postFacade->findByIdForPublicShow($id);

        if (is_null($post)) {
            $this->createNotFoundException('Post not found');
        }

        return $this->render('post_show/index.html.twig', [
            'post' => $post,
            'author' => $userFacade->findByIdForPublicShow($post->getAuthorId()),
            'comments' => $commentFacade->findByPostIdForPublicList($post->getId())
        ]);
    }
}
