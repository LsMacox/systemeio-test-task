<?php

namespace App\Services\PaymentProcessor;

use App\Services\Interfaces\PaymentProcessorInterface;
use App\Services\Sdk\PaymentProcessor\PaypalPaymentProcessor;
use Psr\Container\ContainerInterface;
use Symfony\Contracts\Service\ServiceSubscriberInterface;

class PaypalPaymentProcessorAdapter implements PaymentProcessorInterface, ServiceSubscriberInterface
{
    public function __construct(
        private readonly ContainerInterface $locator
    ) {}

    public static function getSubscribedServices(): array
    {
        return [
            PaypalPaymentProcessor::class,
        ];
    }

    public function process(int $price): bool
    {
        $this->locator->get(PaypalPaymentProcessor::class)->pay($price);

        return true;
    }
}