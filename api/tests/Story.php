<?php

namespace App\Tests;

use App\Factory\BookFactory;

class Story extends \Zenstruck\Foundry\Story
{
    public function build(): void
    {
        BookFactory::createMany(5);
    }
}
