<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class TaxNumber extends Constraint
{
    public $message = 'The taxNumber "{{ taxNumber }}" is invalid format';
}
