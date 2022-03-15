<?php

declare(strict_types=1);

namespace Recharge\Helpers;

use Recharge\Plan;
use Recharge\Shop;
use Recharge\Order;
use Recharge\Charge;
use Recharge\Product;
use Recharge\Webhook;
use Recharge\Customer;
use Recharge\Discount;
use Recharge\Collection;
use Recharge\Subscription;
use Recharge\Address;

class ObjectTypes
{
    public const MAPPING = [
        Address::OBJECT_NAME => Address::class,
        Customer::OBJECT_NAME => Customer::class,
        Collection::OBJECT_NAME => Collection::class,
        Charge::OBJECT_NAME => Charge::class,
        Discount::OBJECT_NAME => Discount::class,
        Order::OBJECT_NAME => Order::class,
        Plan::OBJECT_NAME => Plan::class,
        Product::OBJECT_NAME => Product::class,
        Shop::OBJECT_NAME => Shop::class,
        Subscription::OBJECT_NAME => Subscription::class,
        Webhook::OBJECT_NAME => Webhook::class,
    ];
}
