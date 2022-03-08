<?php

declare(strict_types=1);

namespace Recharge\Services;

use Recharge\Contracts\RechargeClientInterface;
use Recharge\Exceptions\InvalidArgumentException;

use function trim;
use function sprintf;
use function array_map;

abstract class AbstractService
{
    public function __construct(protected RechargeClientInterface $client)
    {
    }

    public function getClient(): RechargeClientInterface
    {
        return $this->client;
    }

    protected function request($method, $path, $params, $objectType, $isList = false)
    {
        return $this->getClient()->request($method, $path, $params, $objectType, $isList);
    }

    protected function requestCollection($method, $path, $params, string $objectType)
    {
        return $this->getClient()->requestCollection($method, $path, $params, $objectType);
    }

    protected function buildPath(string $basepath, ...$ids): string
    {
        foreach ($ids as $id) {
            if (null === $id || (\is_string($id) && '' === trim($id))) {
                throw new InvalidArgumentException('Resource ID\'s cannot be null or whitespace');
            }
        }

        return sprintf($basepath, ...array_map('urlencode', $ids));
    }
}
