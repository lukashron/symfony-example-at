<?php declare(strict_types=1);

namespace App\Api;

use App\Api\Exception\ApiRequestProcessingException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

trait ApiRequestProcessingTrait
{
    /**
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param ResponseInterface $response
     * @param string $class
     * @return array
     * @throws ApiRequestProcessingException
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function deserializeJsonItems(
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        ResponseInterface $response,
        string $class
    ): array
    {
        $listObjects = $serializer->deserialize($response->getContent(), sprintf('%s[]', $class), 'json');

        foreach ($listObjects as $singleObject) {
            $errors = $validator->validate($singleObject);
            if (count($errors) > 0) {
                throw new ApiRequestProcessingException((string) $errors);
            }
        }

        return $listObjects;
    }
}
