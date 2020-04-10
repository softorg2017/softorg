<?php

    return [

        'host' => [
            'local' => [
                'root' => 'http://softorg.com',
                'cdn' => 'http://cdn.softorg.com',
            ],

            'online' => [
                'root' => 'http://softorg.cn',
                'cdn' => 'http://cdn.softorg.cn',
            ],
        ],

        'MailService' => 'http://live2.pub:8088',

        'view' => [
            'front' => [
                'template' => 'online',
                'index' => 'vipp',
                'list' => 'vipp',
                'detail' => 'vipp'
            ],
        ],

        'reserved_keyword' => [
            'item', 'menu', 'module', 'keyword'
        ],


        'website' => [
            'front' => [
                'prefix' => 'org'
            ],
        ],


        'super' => [
            'admin' => [
                'prefix' => 'super-admin'
            ],
        ],


        'org' => [
            'front' => [
                'prefix' => 'org',
                'index' => 'org'
            ],
            'admin' => [
                'prefix' => 'org-admin'
            ],
            'view' => [
                'frontend' => [
                    'template' => 'online',
                    'online' => 'org.frontend.vipp',
                    'index' => 'org.frontend.vipp',
                    'list' => 'org.frontend.vipp',
                    'detail' => 'org.frontend.vipp'
                ],
            ],
        ],


        'common' => [
            'module' => [
                0 => 'default',
                1 => 'product',
                2 => 'article',
                3 => 'activity',
                4 => 'survey',
                5 => 'slide',
            ],

            'sort' => [
                0 => 'default',
                1 => 'product',
                2 => 'article',
                3 => 'activity',
                4 => 'survey',
                5 => 'slide',
            ],
        ],


    ];
