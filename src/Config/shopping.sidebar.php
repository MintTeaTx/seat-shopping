<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/21/2019
 * Time: 12:47 PM
 */
return [
    'payout' => [
        'name'=>'Shopping',
        'permission' => 'shopping.view',
        'route_segment' => 'shopping',
        'icon' => 'fa-shopping-cart',
        'entries' =>    [
            [
                'name' => 'My Orders',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.myorders'
            ]
        ]
    ]
];