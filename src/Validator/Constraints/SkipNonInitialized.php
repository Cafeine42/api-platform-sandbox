<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class SkipNonInitialized extends Constraint
{
    #[HasNamedArguments]
    public function __construct(public readonly Constraint $constraint, ?array $groups = null, mixed $payload = null)
    {
        parent::__construct([], $groups, $payload);
    }

    #[\Override]
    public function getTargets(): string
    {
        return self::PROPERTY_CONSTRAINT;
    }
}
