<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PaymentProcessorValidator extends ConstraintValidator
{
    private ParameterBagInterface $parameter_bag;

    public function __construct(ParameterBagInterface $parameter_bag)
    {
        $this->parameter_bag = $parameter_bag;
    }

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint PaymentProcessor */

        if (!(null === $value || '' === $value) && !in_array($value, array_keys($this->parameter_bag->get('payment_processor')))) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }
}
