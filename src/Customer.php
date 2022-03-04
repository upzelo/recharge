<?php

declare(strict_types=1);

namespace Recharge;

/**
 * @property int                                  $id
 * @property array<string, array<string, string>> $attributes
 * @property string                               $created_at
 * @property string                               $email
 * @property ?array<string, string>               $external_customer_id
 * @property string                               $first_charge_processed_at
 * @property string                               $first_name
 * @property bool                                 $has_payment_method_in_dunning
 * @property bool                                 $has_valid_payment_method
 * @property string                               $hash
 * @property string                               $last_name
 * @property int                                  $subscriptions_active_count
 * @property int                                  $subscriptions_total_count
 * @property string                               $updated_at
 */
class Customer extends ApiResource
{
    public const OBJECT_NAME = 'customer';
}
