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

namespace App\ObjectMapper\Transformer\User;

use App\Api\Resource\User\ApiUser;
use App\Entity\User;
use App\ObjectMapper\Custom\ClassTransformInterface;

/**
 * @implements ClassTransformInterface<User, ApiUser>
 */
final readonly class ReadUserTransformer implements ClassTransformInterface
{
    public function __invoke($source, $target): ApiUser
    {
        $target->isPasswordChanged = true;

        return $target;
    }
}
