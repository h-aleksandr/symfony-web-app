<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Table(name="`tag`")
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\ManyToMany(targetEntity=Review::class, inversedBy="tags")
     */
    private $review;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $name;

    #[Pure] public function __construct()
    {
        $this->review = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        $this->review->removeElement($review);

        return $this;
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
}
