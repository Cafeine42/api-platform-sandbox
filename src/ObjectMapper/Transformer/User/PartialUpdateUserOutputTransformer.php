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

use App\Api\Dto\User\PartialUpdateUserOutput;
use App\Entity\User;
use App\ObjectMapper\Custom\ClassTransformInterface;

/**
 * @implements ClassTransformInterface<User, PartialUpdateUserOutput>
 */
final readonly class PartialUpdateUserOutputTransformer implements ClassTransformInterface
{
    public function __invoke($source, $target): PartialUpdateUserOutput
    {
        return $target;
    }
}
