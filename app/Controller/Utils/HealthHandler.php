<?php

declare(strict_types=1);

namespace App\Controller\Utils;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Coroutine\Parallel;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Redis\RedisFactory;
use Hyperf\Utils\Str;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class HealthHandler
{
    public function __construct(
        protected ContainerInterface $container,
        protected ConfigInterface $config,
        protected RequestInterface $request,
        protected ResponseInterface $response
    ) {}

    public function health(): PsrResponseInterface
    {
        return $this->response->json([
            'message' => 'Alive and kicking!',
            'time' => date(DATE_ATOM),
        ]);
    }

    public function liveness(): array
    {
        $parallel = new Parallel();

        $parallel->add(fn () => $this->testRedisConnection(), 'redis');
        $parallel->add(fn () => $this->testDatabaseConnection(), 'dbs');

        $resources = $parallel->wait();

        return [
            'redis' => $resources['redis'],
            'databases' => $resources['dbs'],
        ];
    }

    protected function testRedisConnection(): array
    {
        $results = [];

        foreach ($this->config->get('redis', []) as $connection => $parameters) {
            $start = microtime(true);

            try {
                $redis = $this->container->get(RedisFactory::class)->get($connection);
                $redis->ping('PING');
                $results[] = [
                    'alive' => true,
                    'host' => Str::mask($parameters['host'], 10),
                    'duration' => $this->calculateTime($start) . ' milliseconds',
                ];
            } catch (\Throwable $e) {
                $results[] = [
                    'alive' => false,
                    'host' => Str::mask($parameters['host'], 10),
                    'error' => $e->getMessage(),
                    'duration' => $this->calculateTime($start) . ' milliseconds',
                ];
            }
        }

        return $results;
    }

    protected function testDatabaseConnection(): array
    {
        $results = [];

        foreach ($this->config->get('databases', []) as $connection => $parameters) {
            $start = microtime(true);

            try {
                Db::connection($connection)->select("SELECT 'Health check'");
                $results[] = [
                    'database' => $parameters['driver'],
                    'alive' => true,
                    'host' => Str::mask($parameters['host'], 7),
                    'duration' => $this->calculateTime($start) . ' milliseconds',
                ];
            } catch (\Throwable $e) {
                $results[] = [
                    'database' => $parameters['driver'],
                    'alive' => false,
                    'host' => Str::mask($parameters['host'], 7),
                    'error' => $e->getMessage(),
                    'duration' => $this->calculateTime($start) . ' milliseconds',
                ];
            }
        }

        return $results;
    }

    protected function calculateTime(float $start): float
    {
        return round((microtime(true) - $start) * 1000);
    }
}
