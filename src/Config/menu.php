<?php

return [
    [
        'route' => 'backender.dashboard',
        'label' => 'backender::header.home',
        'patterns' => [
            'architect',
        ],
        'roles' => [],
    ],

    [
        'route' => 'contents',
        'label' => 'backender::header.contents',
        'patterns' => [
            'architect/contents*',
        ],
        'roles' => [],
    ],

    [
        'route' => 'medias.index',
        'label' => 'backender::header.media',
        'patterns' => [
            'architect/medias*',
        ],
        'roles' => [],
    ],

    [
        'route' => 'settings',
        'label' => 'backender::header.configuration',
        'patterns' => [
            'architect/settings*',
        ],
        'roles' => [],
        //"permissions" => 'settings'
    ],
];
