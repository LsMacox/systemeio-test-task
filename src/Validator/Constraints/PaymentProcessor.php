<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class PaymentProcessor extends Constraint
{
    public $message = 'The value "{{ value }}" is not a valid payment processor.';
}
