<?php

return [
    [
        [
            'icon' => 'HomeIcon',
            'name' => 'Dashboard',
            'route_name' => 'dashboard',
            'valid' => 'dashboard',
        ],
        [
            'icon' => 'StarIcon',
            'name' => 'Job',
            'route_name' => 'job.index',
            'valid' => 'job.*',
        ],
    ],
    [
        // [
        //     'icon'          => 'CurrencyBangladeshiIcon',
        //     'name'          => 'PettyCash',
        //     'route_name'    => 'petty_cash.index',
        //     'valid'         => 'petty_cash.*',
        // ],
        [
            'icon' => 'LibraryIcon',
            'name' => 'Account',
            'route_name' => '#',
            'items' => [
                [
                    'name' => 'Bill (Sales)',
                    'route_name' => 'bill.index',
                    'valid' => 'bill.*',
                ],
                [
                    'name' => 'Collection',
                    'route_name' => 'collection.index',
                    'valid' => 'collection.*',
                ],
                [
                    'name' => 'Payment',
                    'route_name' => 'payment.index',
                    'valid' => 'payment.*',
                ],
            ],
        ],
        // [
        //     'icon'          => 'SpeakerphoneIcon',
        //     'name'          => 'Statement',
        //     'route_name'    => '#',
        //     'items' => [
        //         [
        //             'name'          => 'Account',
        //             'route_name'    => 'account.index',
        //             'valid'         => 'account.*',
        //         ],
        //         [
        //             'name'          => 'Receivable',
        //             'route_name'    => 'asset.index',
        //             'valid'         => 'asset.*',
        //         ],
        //         [
        //             'name'          => 'Payable',
        //             'route_name'    => 'client.index',
        //             'valid'         => 'client.*',
        //         ],
        //         [
        //             'name'          => 'Payment',
        //             'route_name'    => 'user.index',
        //             'valid'         => 'user.*',
        //         ],
        //         [
        //             'name'          => 'Bill n Collection',
        //             'route_name'    => 'user.index',
        //             'valid'         => 'user.*',
        //         ],
        //     ],
        // ],
    ],
    [
        [
            'icon' => 'ColorSwatchIcon',
            'name' => 'Manage',
            'route_name' => '#',
            'items' => [
                [
                    'name' => 'Account',
                    'route_name' => 'account.index',
                    'valid' => 'account.*',
                ],
                [
                    'name' => 'Company',
                    'route_name' => 'company.index',
                    'valid' => 'company.*',
                ],
                [
                    'name' => 'Product',
                    'route_name' => 'product.index',
                    'valid' => 'product.*',
                ],
                // [
                //     'name'          => 'Asset',
                //     'route_name'    => 'asset.index',
                //     'valid'         => 'asset.*',
                // ],
                [
                    'name' => 'Client',
                    'route_name' => 'client.index',
                    'valid' => 'client.*',
                ],
                [
                    'name' => 'User',
                    'route_name' => 'user.index',
                    'valid' => 'user.*',
                ],
            ],
        ],
        [
            'icon' => 'AdjustmentsIcon',
            'name' => 'System',
            'route_name' => '#',
            'items' => [
                [
                    'name' => 'Role (User)',
                    'route_name' => 'role.index',
                    'valid' => 'role.*',
                ],
                [
                    'name' => 'Sector (Payment)',
                    'route_name' => 'sector.index',
                    'valid' => 'sector.*',
                ],
                // [
                //     'name'          => 'Type (Asset)',
                //     'route_name'    => 'type.index',
                //     'valid'         => 'type.*',
                // ],
                [
                    'name' => 'Setting',
                    'route_name' => 'setting.edit',
                    'valid' => 'setting.*',
                ],
            ],
        ],
    ],
];
