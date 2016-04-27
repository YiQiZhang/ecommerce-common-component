<?php

namespace TechTree\Ecommerce\Cart\Providers;

use TechTree\Ecommerce\Cart\Contracts\StorageProviderContract;
use Predis\ClientInterface;

class RedisStorageProvider implements StorageProviderContract
{
    /**
     * @var ClientInterface
     */
    protected $connection;

    public function __construct($keyPrefix)
    {
        $this->connection = app('redis');
    }

    /**
     * @param string $cartUniqueKey
     * @param string $data
     * @param int $ttl(seconds)
     *
     * @return bool
     */
    public function save($cartUniqueKey, $data, $ttl)
    {
        return $this->connection->setex($cartUniqueKey, $ttl, $data);
    }

    /**
     * @param string $cartUniqueKey
     *
     * @return string
     */
    public function restore($cartUniqueKey)
    {
        return $this->connection->get($cartUniqueKey);
    }

    /**
     * @param string $cartUniqueKey
     *
     * @return void
     */
    public function remove($cartUniqueKey)
    {
        $this->connection->del($cartUniqueKey);
    }
}