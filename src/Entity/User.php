<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface,PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\Column(type: 'string', length: 255)]
    private $address;

    #[ORM\Column(type: "json")]
    private $roles = [];

    #[ORM\Column(type: 'string')]
    private $password;
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Comment")
     * @ORM\JoinTable(name="user_favorite_comments")
     */
    #[ORM\ManyToMany(targetEntity: Comment::class,inversedBy: "userFavorites")]
    #[ORM\JoinTable("user_favorite_comments")]
    private $favorites;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class)]
    private $comments;


    #[ORM\ManyToOne(targetEntity: Comment::class)]
    private $firstComment;

    #[ORM\OneToMany(mappedBy :"author", targetEntity: Comment::class)]
    private $authoredComments;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->favorites = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getAuthoredComments()
    {
        return $this->authoredComments;
    }

    /**
     * @return mixed
     */
    public function getFirstComment() : Comment
    {
        return $this->firstComment;
    }

    /**
     * @param mixed $firstComment
     */
    public function setFirstComment(Comment $firstComment): void
    {
        $this->firstComment = $firstComment;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFavoriteComments() {
        return $this->favorites;
    }

    /**
     * @param mixed $favorites
     */
    public function setFavoriteComments($favorites): void
    {
        $this->favorites = $favorites;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getComments()
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setUser($this);
        }

        return $this;
    }

    /**
     * The public representation of the user (e.g. a username, an email address, etc.)
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

}
