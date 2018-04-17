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

        'website' => [
            'front' => [
                'prefix' => 'org'
            ],
        ],

        'org' => [

            'front' => [
                'prefix' => 'org',
                'index' => 'o'
            ],

            'admin' => [
                'prefix' => 'org'
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
