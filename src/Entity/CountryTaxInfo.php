<?php

namespace App\Entity;

use App\Repository\CountryTaxInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryTaxInfoRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class CountryTaxInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $format = null;

    #[ORM\Column]
    private ?int $rate_percent = null;

    #[ORM\Column]
    private ?int $amount_threshold = null;

    #[ORM\Column(length: 50)]
    private ?string $country_code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country_name = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): static
    {
        $this->format = $format;

        return $this;
    }

    public function getRatePercent(): ?int
    {
        return $this->rate_percent;
    }

    public function setRatePercent(int $rate_percent): static
    {
        $this->rate_percent = $rate_percent;

        return $this;
    }

    public function getAmountThreshold(): ?int
    {
        return $this->amount_threshold;
    }

    public function setAmountThreshold(int $amount_threshold): static
    {
        $this->amount_threshold = $amount_threshold;

        return $this;
    }

    public function getCountryCode(): ?string
    {
        return $this->country_code;
    }

    public function setCountryCode(string $country_code): static
    {
        $this->country_code = $country_code;

        return $this;
    }

    public function getCountryName(): ?string
    {
        return $this->country_name;
    }

    public function setCountryName(string $country_name): static
    {
        $this->country_name = $country_name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        $this->created_at = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function setUpdatedAtValue(): void
    {
        $this->updated_at = new \DateTimeImmutable();
    }

    public function getFormatRegex(): string
    {
        preg_match_all( '/((X)|(Y))/', $this->format, $matches);
        $digit_count = count(array_filter($matches[2]));
        $letter_count = count(array_filter($matches[3]));
        $reg_format = preg_replace('/X+/', '\d{' . $digit_count . '}', $this->format);
        $reg_format = preg_replace('/Y+/', '[a-zA-Z]{' . $letter_count . '}', $reg_format);
        return '/' . $reg_format . '/';
    }
}
