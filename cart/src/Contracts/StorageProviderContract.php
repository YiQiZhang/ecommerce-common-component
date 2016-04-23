<?php

namespace TechTree\Ecommerce\Cart\Contracts;

interface StorageProviderContract
{
    public function save(CartContract $cart);

    public function restore($cartUniqueKey);

    public function remove($cartUniqueKey);
}