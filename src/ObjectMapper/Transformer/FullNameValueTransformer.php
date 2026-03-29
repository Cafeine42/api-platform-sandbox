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

namespace App\ObjectMapper\Transformer;

use App\ObjectMapper\Custom\ValueTransformInterface;
use Webmozart\Assert\Assert;

/**
 * @implements ValueTransformInterface<object|null, string|null>
 */
class FullNameValueTransformer implements ValueTransformInterface
{
    public function __invoke($value): ?string
    {
        if (null === $value) {
            return null;
        }

        Assert::methodExists($value, 'getLastname', 'Object must have a getName method');
        Assert::methodExists($value, 'getFirstname', 'Object must have a getName method');

        return $value->getLastname().' '.$value->getFirstname();
    }
}
