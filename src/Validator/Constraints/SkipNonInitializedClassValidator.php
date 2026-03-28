<?php

declare(strict_types=1);

/*
 * This file is part of the project Elsie ERP.
 *
 * Copyright (C) Elsie - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 */

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SkipNonInitializedClassValidator extends ConstraintValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SkipNonInitializedClass) {
            throw new UnexpectedTypeException($constraint, SkipNonInitializedClass::class);
        }

        if (!\is_object($value)) {
            throw new UnexpectedTypeException($value, 'object');
        }

        $object = get_object_vars($value);

        foreach ($constraint->properties as $property) {
            if (!\array_key_exists($property, $object)) {
                return;
            }
        }

        $constraintViolationList = $this->validator->validate($value, $constraint->constraint);
        foreach ($constraintViolationList as $constraintViolation) {
            $this->context->getViolations()->add($constraintViolation);
        }
    }
}
