<?php

include('vendor/autoload.php');

// $client = new \Recharge\RechargeClient('sk_1x1_dd48b66f2096b4b4593d3d64480717b2e3e2604a9cf04f14bbea28383860fe39');

// $client = new \Recharge\RechargeClient('sk_1x1_dd48b66f2096b4b4593d3d64480717b2e3e2604a9cf04f14bbea28383860fe39');
$client = new \Recharge\RechargeClient('sk_1x1_adbdf25d28b7ab3b5c088241b61af7265579ce1db3805852e78d8498bc7b3b19');

// $customer = $client->customer->retrieve(75817948);
// dd($customer);

// $customers = $client->customer->all(['limit' => 1]);

// dd($client->customer->all(['limit' => 1]));

// dd($client->discount->all());

// dd($client->discount->create([
//     'applies_to' => [
//         'purchase_item_type' => 'SUBSCRIPTION',
//     ],
//     'channel_settings' => [
//         'api' => [
//             'can_apply' => true,
//         ],
//     ],
//     'code' => 'TEST10OFF_ONCE',
//     'usage_limits' => [
//         'automatic_redemptions_per_customer' => 1,
//         'one_application_per_customer' => true,
//     ],
//     'value_type' => 'percentage',
//     'value' => '10',
// ]));

dd($client->webhook->all());
