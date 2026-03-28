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

class SkipNonInitializedValidator extends ConstraintValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof SkipNonInitialized) {
            throw new UnexpectedTypeException($constraint, SkipNonInitialized::class);
        }

        $object = $this->context->getObject();
        $field = $this->context->getPropertyName();

        if ($object && $field && !$this->existField($field, $object)) {
            return;
        }

        $constraintViolationList = $this->validator->validate($value, $constraint->constraint);
        foreach ($constraintViolationList as $constraintViolation) {
            $this->context->getViolations()->add($constraintViolation);
        }
    }

    private function existField(string $field, object $object): bool
    {
        return \array_key_exists($field, get_object_vars($object));
    }
}
