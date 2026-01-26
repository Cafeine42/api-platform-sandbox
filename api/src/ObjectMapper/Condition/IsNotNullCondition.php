<?php

namespace App\ObjectMapper\Condition;

use Symfony\Component\ObjectMapper\ConditionCallableInterface;

/**
 * This condition can be used by the ObjectMapper to avoid mapping null properties,
 * ensuring support for PATCH requests where only provided values should be updated.
 *
 * @template T of object
 *
 * @implements ConditionCallableInterface<object, T>
 */
class IsNotNullCondition implements ConditionCallableInterface
{
    public function __invoke(mixed $value, object $source, ?object $target): bool
    {
        return null !== $value;
    }
}
