<?php declare(strict_types=1);

namespace App\Controller;

use App\Model\Post\PostFacade;
use App\Paginator\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    /**
     * @param PostFacade $postFacade
     * @param int $page
     * @return Response
     */
    #[Route('/{page}', name: 'app_homepage', requirements: ['page' => '\d+'], defaults: ['page' => 1])]
    public function index(
        PostFacade $postFacade,
        int $page
    ): Response
    {
        $countPosts = $postFacade->countForPublicList();

        $paginator = new Paginator(25, $countPosts, $page);

        return $this->render('homepage/index.html.twig', [
            'posts' => $postFacade->findAllForPublicList(
                $paginator->getItemsPerPage(),
                $paginator->getOffset()
            ),
            'paginator' => $paginator
        ]);
    }
}
