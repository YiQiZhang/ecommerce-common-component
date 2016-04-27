<?php

namespace TechTree\Ecommerce\Cart\Contracts;

use TechTree\Ecommerce\Cart\Models\Counter;

interface CounterFilterContract
{
    public function filter(Counter $counter);
}