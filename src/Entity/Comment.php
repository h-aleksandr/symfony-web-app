<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommentRepository::class)
 */
class Comment
{
    private const PUBLISHED = true;
    private const DRAFT = false;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="text")
     */
    private string $text;

    /**
     * @ORM\ManyToOne(targetEntity=Review::class, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private Review $review;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTime $create_at;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private \DateTime $update_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $is_published;


    public function getId(): int
    {
        return $this->id;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getReview(): Review
    {
        return $this->review;
    }

    public function setReview(Review $review): self
    {
        $this->review = $review;

        return $this;
    }

    public function getCreateAt(): \DateTimeImmutable
    {
        return $this->create_at;
    }

    public function setCreateAt(\DateTimeImmutable $create_at): self
    {
        $this->create_at = $create_at;

        return $this;
    }

    public function getUpdateAt(): \DateTimeImmutable
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeImmutable $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    public function getIsPublished(): bool
    {
        return $this->is_published;
    }

    public function setIsPublished(): self
    {
        $this->is_published = self::PUBLISHED;

        return $this;
    }

    public function setIsDraft(): self{
        $this->is_published = self::DRAFT;

        return $this;
    }
}
