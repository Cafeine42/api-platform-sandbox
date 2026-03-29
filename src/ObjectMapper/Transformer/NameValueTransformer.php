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
 * @implements ValueTransformInterface<mixed, string>
 */
class NameValueTransformer implements ValueTransformInterface
{
    public function __invoke($value)
    {
        Assert::object($value);
        Assert::methodExists($value, 'getName', 'Object must have a getName method');

        return $value->getName();
    }
}
