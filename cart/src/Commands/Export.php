<?php

namespace TechTree\Ecommerce\Cart\Commands;

use Illuminate\Console\Command;
use Predis\Client;
use TechTree\Ecommerce\Cart\Providers\RedisStorageProvider;

class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cart:export {file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'export cart in redis with session identifier.';

    public function handle()
    {
        $filename = $this->argument('file');
        $fp = fopen($filename, 'w');
        if ($fp) {
            $this->error(sprintf('file: %s open fail', $filename));

            return;
        }

        /** @var Client $connection */
        $connection = app('redis');
        $connection->pipeline(function ($pipe) use ($fp) {
            /* @var Client $pipe */
            $keys = $pipe->hkeys(RedisStorageProvider::CART_HASH_KEY);
            foreach ($keys as $key) {
                $dataString = $pipe->get($key);
                fwrite($fp, $dataString, strlen($dataString));
                fwrite($fp, '\n');
            }
        });

        fclose($fp);
    }
}
