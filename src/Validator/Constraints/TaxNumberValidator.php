<?php

namespace App\Validator\Constraints;

use App\Repository\CountryTaxInfoRepository;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class TaxNumberValidator extends ConstraintValidator
{
    public function __construct(
        private readonly CountryTaxInfoRepository $repository
    ) {}

    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint TaxNumber */

        if (null === $value || '' === $value) {
            return;
        }

        $countries_tax_info = $this->repository->findAll();

        $checkValue = false;

        // Скорее в базе надо хранить regex, старался не отходить от тестового задания
        foreach ($countries_tax_info as $country_tax_info) {
            if (preg_match($country_tax_info->getFormatRegex(), $value)) {
                $checkValue = true;
                break;
            }
        }

        if (!$checkValue) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ taxNumber }}', $value)
                ->addViolation();
        }
    }
}
