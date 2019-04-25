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
        'route_segment' => 'shopping',
        'icon' => 'fa-shopping-cart',
        'entries' =>    [
            [
                'name' => 'My Orders',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.myorders'
            ],
            [
                'name' => 'My Config',
                'icon' => 'fa-snowflake-o',
                'route_segment' => 'shopping',
                'route' => 'shopping.myorders'
            ],
        ],
    ],
];