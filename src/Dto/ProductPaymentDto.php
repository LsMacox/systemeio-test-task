<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as AppAssert;
use Happyr\Validator\Constraint\EntityExist;

class ProductPaymentDto
{
    #[Assert\NotBlank]
    #[EntityExist('App\Entity\Product', 'id')]
    private int $product;
    #[Assert\NotBlank]
    #[AppAssert\TaxNumber]
    private string $taxNumber;
    #[EntityExist('App\Entity\Coupon', 'code')]
    private ?string $couponCode = '';
    #[AppAssert\PaymentProcessor]
    private string $paymentProcessor;

    public function getProduct(): int
    {
        return $this->product;
    }

    public function setProduct(int $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function setTaxNumber(string $taxNumber): self
    {
        $this->taxNumber = $taxNumber;

        return $this;
    }

    public function getCouponCode(): ?string
    {
        return $this->couponCode;
    }

    public function setCouponCode(?string $couponCode): self
    {
        $this->couponCode = $couponCode;

        return $this;
    }

    public function getPaymentProcessor(): string
    {
        return $this->paymentProcessor;
    }

    public function setPaymentProcessor(string $paymentProcessor): self
    {
        $this->paymentProcessor = $paymentProcessor;

        return $this;
    }
}
