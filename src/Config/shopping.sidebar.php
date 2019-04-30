<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 4/21/2019
 * Time: 12:47 PM
 */

return [
    'shopping' => [
        'name'=>'Shopping',
        'permission' => 'shopping.order',
        'route_segment' => 'shopping',
        'icon' => 'fa-shopping-cart',
        'entries' =>    [
            [
                'name' => 'My Orders',
                'permission' => 'shopping.order',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.myorders'
            ],
            [
                'name' => 'View All Orders',
                'permission' => 'shopping.hauler',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.handler.list'
            ],
            [
                'name' => 'View My Assigned Orders',
                'permission' => 'shopping.hauler',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.handler.myassigned'
            ],
        ],
    ],
];