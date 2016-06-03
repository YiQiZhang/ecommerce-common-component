<?php

namespace TechTree\Ecommerce\Cart\Providers;

use Carbon\Carbon;
use Predis\Client;
use TechTree\Ecommerce\Cart\Contracts\StorageProviderContract;

class RedisStorageProvider implements StorageProviderContract
{
    const CART_HASH_KEY = 'cart:hash:expire';

    /**
     * @var Client
     */
    protected $connection;

    protected $keyPrefix;

    public function __construct($database = '', $keyPrefix = '')
    {
        $this->keyPrefix = $keyPrefix;
        if (!empty($database)) {
            $this->connection = app('redis')->connection($database);
        } else {
            $this->connection = app('redis');
        }
    }

    /**
     * @param string $cartUniqueKey
     * @param string $data
     * @param int $ttl(seconds)
     *
     * @return bool
     */
    public function save($cartUniqueKey, &$data, $ttl)
    {
        $this->connection->pipeline(['atomic' => true], function($pipe) use ($cartUniqueKey, &$data, $ttl){
            /** @var Client $pipe */
            $pipe->setex($cartUniqueKey, $ttl, $data);
            $expire = Carbon::now()->timestamp + $ttl;
            $pipe->hset(self::CART_HASH_KEY, $cartUniqueKey, $expire);
        });

        return true;
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
        $this->connection->pipeline(['atomic' => true], function($pipe) use (&$cartUniqueKey){
            /** @var Client $pipe */
            $pipe->del($cartUniqueKey);
            $pipe->hdel(self::CART_HASH_KEY, $cartUniqueKey);
        });
    }

    /**
     * @return string[]
     */
    public function all()
    {
        return $this->connection->hkeys(self::CART_HASH_KEY);
    }
}