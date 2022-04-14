<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;


    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'comments')]
    private $user;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $user_id;

    #[ORM\ManyToOne(targetEntity: User::class,inversedBy: "commentsAuthored")]
    private $author;

    #[ORM\ManyToMany(targetEntity: User::class,mappedBy: "favorites")]
    private $userFavorites;

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor(User $author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser(?User $user): void
    {
        $this->user = $user;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getUserFavorites() {
        return $this->userFavorites;
    }

}
