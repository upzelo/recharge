<?php

declare(strict_types=1);

namespace Recharge;

use Recharge\Services\PlanService;
use Recharge\Services\OrderService;
use Recharge\Services\ChargeService;
use Recharge\Services\ServiceFactory;
use Recharge\Services\ProductService;
use Recharge\Services\WebhookService;
use Recharge\Services\AddressService;
use Recharge\Services\CustomerService;
use Recharge\Services\DiscountService;
use Recharge\Services\SubscriptionService;

/**
 * @property AddressService      $address
 * @property CustomerService     $customer
 * @property ChargeService       $charge
 * @property DiscountService     $discount
 * @property OrderService        $order
 * @property PlanService         $plan
 * @property ProductService      $product
 * @property SubscriptionService $subscription
 * @property WebhookService      $webhook
 */
class RechargeClient extends BaseRechargeClient
{
    private ?ServiceFactory $serviceFactory = null;

    public function __get(string $name): mixed
    {
        if (null === $this->serviceFactory) {
            $this->serviceFactory = new ServiceFactory($this);
        }

        return $this->serviceFactory->__get($name);
    }
}
