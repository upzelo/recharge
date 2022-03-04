<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Contracts\RechargeClientInterface;

use function trigger_error;
use function array_key_exists;

abstract class AbstractServiceFactory
{
    private array $services = [];

    public function __construct(private RechargeClientInterface $client)
    {
    }

    public function __get($name)
    {
        $service = $this->getServiceClass($name);

        if (null !== $service) {
            if (!array_key_exists($name, $this->services)) {
                $this->services[$name] = new $service($this->client);
            }

            return $this->services[$name];
        }

        trigger_error('Undefined property: ' . static::class . '::$' . $name);

        return null;
    }

    abstract protected function getServiceClass(string $name);
}
