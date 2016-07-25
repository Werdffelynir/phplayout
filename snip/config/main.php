<?php

return [
    'filesystem_owner' => 'www-data',
    'name' => 'Snippets application',
    'router' => [
        'path' => '/',
    ],
    'layout' => [
        'path' => 'views',
        'template' => 'layout/template',
    ],
    'db' => [
        'dsn' => 'sqlite:'.dirname(__DIR__).'/database/main.db',
        'username' => '',
        'passwd' => '',
        'options' => [],
    ],
];