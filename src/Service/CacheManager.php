<?php
namespace App\Service;
use Symfony\Component\Cache\Adapter\ApcuAdapter;
class CacheManager
{
    private $cacheAdapter;
    public function __construct()
    {
        $this->cacheAdapter = new ApcuAdapter();
    }
    public function get(string $key)
    {
        return $this->cacheAdapter->getItem($key)->get();
    }
    public function set(string $key, $value, int $ttl = 3600): void
    {
        $cacheItem = $this->cacheAdapter->getItem($key);
        $cacheItem->set($value);
        $cacheItem->expiresAfter($ttl);
        $this->cacheAdapter->save($cacheItem);
    }
}
