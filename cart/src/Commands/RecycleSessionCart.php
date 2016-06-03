<?php

namespace TechTree\Ecommerce\Cart\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Predis\Client;
use TechTree\Ecommerce\Cart\Providers\RedisStorageProvider;

class RecycleSessionCart extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:recycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recyle expired carts with session identifier.';

    public function handle()
    {
        /** @var Client $connection */
        $connection = app('redis');
        $connection->pipeline(function($pipe){
            /** @var Client $pipe */
            $now = Carbon::now()->timestamp;
            $keys = $pipe->hkeys(RedisStorageProvider::CART_HASH_KEY);
            foreach($keys as $key) {
                $ttl = $pipe->hget(RedisStorageProvider::CART_HASH_KEY, $key);
                if ($ttl < $now) {
                    $pipe->hdel(RedisStorageProvider::CART_HASH_KEY, $key);
                }
            }
        });
    }
}