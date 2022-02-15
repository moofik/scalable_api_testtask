<?php

namespace App\Service\Statistics;

use Predis\ClientInterface;

class VisitorStatistics
{
    private const PREFIX_COUNTRY = 'country_key_';

    private ClientInterface $redis;

    /**
     * @param ClientInterface $redis
     */
    public function __construct(ClientInterface $redis)
    {
        $this->redis = $redis;
    }

    /**
     * @param string $code
     */
    public function increment(string $code): void
    {
        if ($code) {
            $count = $this->redis->get(self::PREFIX_COUNTRY . $code);

            if ($count) {
                $this->redis->set(self::PREFIX_COUNTRY . $code, ++$count);
            } else {
                $this->redis->set(self::PREFIX_COUNTRY . $code, 1);
            }
        } else {
            throw new \InvalidArgumentException("code argument is empty");
        }
    }

    /**
     * @return array
     */
    public function get(): array
    {
        $keys = $this->redis->keys(self::PREFIX_COUNTRY . '*');
        $results = [];
        $prefixLen = strlen(self::PREFIX_COUNTRY);

        foreach ($keys as $index => $key) {
            $results[substr($key, $prefixLen)] = $this->redis->get($key);
        }

        return $results;
    }
}