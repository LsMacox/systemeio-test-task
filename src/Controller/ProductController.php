<?php

namespace App\Controller;

use App\Dto\ProductPaymentDto;
use App\Form\Type\ProductPaymentType;
use App\Repository\ProductRepository;
use App\Services\Interfaces\CalculatorInterface;
use App\Services\Interfaces\PaymentProcessorInterface;
use App\Services\PaymentProcessor\PaypalPaymentProcessorAdapter;
use App\Services\PaymentProcessor\StripePaymentProcessorAdapter;
use App\Services\ProductPriceCalculators\Calculator;
use App\Services\ProductPriceCalculators\CouponCalculator;
use App\Services\ProductPriceCalculators\TaxCalculator;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly ContainerInterface $locator
    ) {}

    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            PaypalPaymentProcessorAdapter::class,
            StripePaymentProcessorAdapter::class,
            Calculator::class,
            CouponCalculator::class,
            TaxCalculator::class,
        ]);
    }

    public function calcPrice(Request $request, ProductRepository $product_repository): Response
    {
        $dto = new ProductPaymentDto();

        $form = $this->createForm(ProductPaymentType::class, $dto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $calculator = $this->getCalculator();
            $product = $product_repository->find($dto->getProduct());

            return new Response('Price: ' . $calculator->calculate($dto, $product->getPrice()));
        }

        return $this->render('base.html.twig', [
            'form' => $form,
        ]);
    }

    public function pay(
        ParameterBagInterface $parameter_bag,
        ProductRepository $product_repository,
        #[MapRequestPayload]
        ProductPaymentDto
        $dto
    ): Response
    {
        /** @var PaymentProcessorInterface $payment_processor */
        $payment_processor = $this->locator->get($parameter_bag->get('payment_processor')[$dto->getPaymentProcessor()]);
        /** @var CalculatorInterface $calculator */
        $calculator = $this->getCalculator();

        $product = $product_repository->find($dto->getProduct());
        $price = $calculator->calculate($dto, $product->getPrice());

        try {
            $payment_processor->process($price);

            return new Response('Congratulations! Payment successful');
        } catch (\Exception $exception) {
            return new Response($exception->getMessage(), 400);
        }
    }

    protected function getCalculator(): Calculator
    {
        $calculator = $this->locator->get(Calculator::class);
        $calculator->setCalculators([
            $this->locator->get(CouponCalculator::class),
            $this->locator->get(TaxCalculator::class)]
        );

        return $calculator;
    }
}
