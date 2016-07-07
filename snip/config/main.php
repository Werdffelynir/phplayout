<?php

return [
    'name' => 'Snippets application',
    'router' => [
        'path' => '/',
    ],
    'layout' => [
        'path' => 'views',
        'template' => 'layout/template',
    ],
    'db' => [
        'dsn' => 'sqlite:database/treen.sqlite3',
        'username' => '',
        'passwd' => '',
        'options' => [],
    ],
];