<?php declare(strict_types=1);

namespace App\Model\Post;

use Symfony\Component\Serializer\Attribute\Ignore;
use Symfony\Component\Serializer\Attribute\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

class PostDto
{
    #[Ignore]
    private ?int $id;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[SerializedName('id')]
    private int $externalId;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $title;

    #[Assert\NotBlank]
    #[Assert\Type('string')]
    private string $body;

    #[Assert\NotBlank]
    #[Assert\Type('integer')]
    #[SerializedName('userId')]
    private int $authorId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }
}
