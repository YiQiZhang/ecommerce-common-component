<?php

namespace TechTree\Ecommerce\Cart\Contracts;

interface StorageProviderContract
{
    /**
     * @param string $cartUniqueKey
     * @param string $data
     * @param int $ttl(seconds)
     *
     * @return bool
     */
    public function save($cartUniqueKey, $data, $ttl);

    /**
     * @param string $cartUniqueKey
     *
     * @return string
     */
    public function restore($cartUniqueKey);

    /**
     * @param string $cartUniqueKey
     *
     * @return void
     */
    public function remove($cartUniqueKey);
}