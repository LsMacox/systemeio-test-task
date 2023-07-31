<?php

namespace App\Services\PaymentProcessor;

use App\Services\Interfaces\PaymentProcessorInterface;
use App\Services\Sdk\PaymentProcessor\StripePaymentProcessor;
use Psr\Container\ContainerInterface;

class StripePaymentProcessorAdapter implements PaymentProcessorInterface
{
    public function __construct(
        private readonly ContainerInterface $locator
    ) {}

    public static function getSubscribedServices(): array
    {
        return [
            StripePaymentProcessor::class,
        ];
    }

    public function process(int $price): bool
    {
        return $this->locator->get(StripePaymentProcessor::class)->processPayment($price);
    }
}