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
 * @template T as object
 * Interface to transform a class into another (global transformation).
 */
interface ClassFactoryInterface
{
    /**
     * @param class-string<T> $target the target class
     *
     * @return T the transformed or re-instantiated target object
     */
    public function __invoke($target);
}
