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
 * Defines the mapping of a source property to a target property.
 */
final class PropertyMapping
{
    /**
     * @param string                                 $source    Source property name
     * @param string|null                            $target    Target property name (defaults to source if null)
     * @param array<array-key, callable|string>|null $transform Callable used to transform the property value
     */
    public function __construct(
        public readonly string $source,
        public readonly ?string $target = null,
        public readonly mixed $transform = null,
    ) {
    }

    /**
     * Returns the target property name.
     */
    public function getTarget(): string
    {
        return $this->target ?? $this->source;
    }
}
