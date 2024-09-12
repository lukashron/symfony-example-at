<?php declare(strict_types=1);

namespace App\Model\TypiCode;

use App\Model\Comment\CommentDtoFactory;
use App\Model\Post\PostDtoFactory;
use App\Model\User\UserDtoFactory;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class TypiCodeApiFacade
{
    const BASE_URL = 'https://jsonplaceholder.typicode.com';

    public function __construct(
        private readonly HttpClientInterface $client,
        private readonly UserDtoFactory $userDtoFactory,
        private readonly PostDtoFactory $postDtoFactory,
        private readonly CommentDtoFactory $commentDtoFactory
    )
    {
    }

    /**
     * @param string $endpoint
     * @return string
     */
    public function makeRequestUrl(string $endpoint): string
    {
        return sprintf('%s/%s', self::BASE_URL, $endpoint);
    }

    /**
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchUsers(): ResponseInterface
    {
        return $this->client->request('GET', $this->makeRequestUrl('users'));
    }

    /**
     * @return array
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makeUsersDtoListFromApi(): array
    {
        return $this->userDtoFactory->makeFromApiResponse(
            $this->fetchUsers()
        );
    }

    /**
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchPosts(): ResponseInterface
    {
        return $this->client->request('GET', $this->makeRequestUrl('posts'));
    }

    /**
     * @return array
     * @throws \App\Api\Exception\ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makePostsDtoListFromApi(): array
    {
        return $this->postDtoFactory->makeFromApiResponse(
            $this->fetchPosts()
        );
    }

    /**
     * @return ResponseInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function fetchComments(): ResponseInterface
    {
        return $this->client->request('GET', $this->makeRequestUrl('comments'));
    }

    /**
     * @return array
     * @throws \App\Api\Exception\ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function makeCommentsDtoListFromApi(): array
    {
        return $this->commentDtoFactory->makeFromApiResponse(
            $this->fetchComments()
        );
    }
}
