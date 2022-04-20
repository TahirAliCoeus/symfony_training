<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Serializer\Filter\PropertyFilter;
use App\Repository\UserListingRepository;
use Carbon\Carbon;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UserListingRepository::class)]
#[ApiResource(collectionOperations: ['get','post'],
    itemOperations: ['get',"put","patch","delete",],
    shortName: "users",
    attributes: ["pagination_items_per_page" => 2],
    denormalizationContext: ['groups' => ['users:write']],
    normalizationContext: ['groups' => ['users:read']]

)]
#[ApiFilter(BooleanFilter::class,properties: ['isActive'])]
#[ApiFilter(SearchFilter::class,properties: ['name'])]
#[ApiFilter(PropertyFilter::class)]
class UserListing
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['users:read','users:write'])]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['users:read','users:write'])]
    private $email;

    #[ORM\Column(type: 'integer')]
    #[Groups(['users:read','users:write'])]
    private $age;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['users:read','users:write'])]
    private $isActive;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsActive()
    {
        return $this->isActive;
    }

    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    #[Groups(['users:read'])]
    #[SerializedName("created")]
    public function getCreatedAtAgo()
    {
        return Carbon::instance($this->getCreatedAt())->diffForHumans();
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    #[Groups(['users:write'])]
    #[SerializedName("created")]
    public function setCreatedAt($createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }
}
