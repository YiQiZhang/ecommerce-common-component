<?php

namespace TechTree\Ecommerce\Cart\Providers;

use TechTree\Ecommerce\Cart\Contracts\StorageProviderContract;

class TemporaryStorageProvider implements StorageProviderContract
{
    /**
     * @param string $cartUniqueKey
     * @param string $data
     * @param int $ttl(seconds)
     *
     * @return bool
     */
    public function save($cartUniqueKey, &$data, $ttl)
    {
        return ;
    }

    /**
     * @param string $cartUniqueKey
     *
     * @return string
     */
    public function restore($cartUniqueKey)
    {
        return ;
    }

    /**
     * @param string $cartUniqueKey
     *
     * @return void
     */
    public function remove($cartUniqueKey)
    {
        return ;
    }

    /**
     * 所有保存在该Provider的购物车的uniqueKey名
     *
     * @return string[]
     */
    public function all()
    {
        return [];
    }
}