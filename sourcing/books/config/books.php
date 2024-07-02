<?php

return [
    'go' => [
        'username' => env('TRANSPORT_GO_USERNAME'),
        'password' => env('TRANSPORT_GO_PASSWORD'),
        'base_url' => env('TRANSPORT_GO_URL', 'https://ws-tst.api.general-overnight.com/'),
        'responsibleStation' => env('TRANSPORT_GO_RESPONSIBLE_STATION', 'FRA'),
        'customerId' => env('TRANSPORT_GO_CUSTOMER_ID', '123456'),
        'service' => env('TRANSPORT_GO_SERVICE', 'ON'),
        'defaultPickupTimeFrom' => env('TRANSPORT_GO_DEFAULT_PICKUP_TIME_FROM', '15:00'),
        'defaultPickupTimeTill' => env('TRANSPORT_GO_DEFAULT_PICKUP_TIME_TILL', '17:00'),
        'defaultDeliveryTimeFrom' => env('TRANSPORT_GO_DEFAULT_DELIVERY_TIME_FROM', '7:00'),
        'defaultDeliveryTimeTill' => env('TRANSPORT_GO_DEFAULT_DELIVERY_TIME_TILL', '8:00'),
    ]
];
