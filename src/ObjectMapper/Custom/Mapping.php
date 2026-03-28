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

namespace App\ObjectMapper\Custom;

/**
 * Defines a mapping from source to target with an optional global transformation.
 */
final class Mapping
{
    /**
     * @param string                                 $source     Source class name
     * @param string                                 $target     Target class name
     * @param array<array-key, callable|string>|null $transform  Callable called to transform source to target: transform(source, ?target): target
     * @param array<string, PropertyMapping>         $properties List of property mappings
     */
    public function __construct(
        public readonly string $source,
        public readonly string $target,
        public readonly mixed $transform = null,
        public readonly array $properties = [],
    ) {
    }
}
