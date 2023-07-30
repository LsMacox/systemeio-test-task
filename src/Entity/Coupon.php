<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
#[ORM\Table('coupons')]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?int $discount_type = null;

    #[ORM\Column]
    private ?int $discount_amount = null;

    #[ORM\Column]
    private ?bool $is_used = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $valid_until = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getDiscountType(): ?int
    {
        return $this->discount_type;
    }

    public function setDiscountType(int $discount_type): static
    {
        $this->discount_type = $discount_type;

        return $this;
    }

    public function getDiscountAmount(): ?int
    {
        return $this->discount_amount;
    }

    public function setDiscountAmount(int $discount_amount): static
    {
        $this->discount_amount = $discount_amount;

        return $this;
    }

    public function isIsUsed(): ?bool
    {
        return $this->is_used;
    }

    public function setIsUsed(bool $is_used): static
    {
        $this->is_used = $is_used;

        return $this;
    }

    public function getValidUntil(): ?\DateTime
    {
        return $this->valid_until;
    }

    public function setValidUntil(?\DateTime $valid_until): static
    {
        $this->valid_until = $valid_until;

        return $this;
    }
}
