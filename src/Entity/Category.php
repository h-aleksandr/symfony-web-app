<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="category")
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{

    public const PUBLISHED = true;
    public const DRAFT = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private string $description;

    /**
     * @ORM\OneToMany(targetEntity=Review::class, mappedBy="category")
     */
    private $reviews;

//    public function __construct()
//    {
//        $this->reviews = new ArrayCollection();
//    }

//    public function __toString():string
//    {
//        return (string)$this->getReviews();
//    }

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|null
     */
    public function getReviews(): ?Collection
    {
        return $this->reviews;
    }

    public function addReview(?Review $review): self
    {
        if (!$this->reviews->contains($review)) {
            $this->reviews[] = $review;
            $review->setCategory($this);
        }

        return $this;
    }

    public function removeReview(?Review $review): self
    {
        if ($this->reviews->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getCategory() === $this) {
                $review->setCategory(null);
            }
        }

        return $this;
    }
}
