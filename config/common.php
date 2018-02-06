<?php

    return [

        'host' => 'http://softorg.cn',
        'cdn' => 'http://cdn.softorg.cn',

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
