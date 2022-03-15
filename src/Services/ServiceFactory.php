<?php

declare(strict_types=1);

namespace Recharge\Services;

/**
 * @property CustomerService $customer
 */
class ServiceFactory extends AbstractServiceFactory
{
    private static array $classMap = [
        'address' => AddressService::class,
        'customer' => CustomerService::class,
        'charge' => ChargeService::class,
        'discount' => DiscountService::class,
        'order' => OrderService::class,
        'plan' => PlanService::class,
        'product' => ProductService::class,
        'shop' => ShopService::class,
        'subscription' => SubscriptionService::class,
        'webhook' => WebhookService::class,
    ];

    public function getServiceClass(string $name)
    {
        return self::$classMap[$name] ?? null;
    }
}
