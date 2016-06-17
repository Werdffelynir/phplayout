<?php

include '../src/Layout.php';

$config = [
    'path' => __DIR__.'/views/',
    'template' => 'layout/template',
];

$layout = new Layout($config);

$layout->setPosition('header','layout/header.php');

$layout->setPosition('navigation','layout/navigation.php');

$layout->setPosition('banner','banner.php');

$layout->value('banner2', $layout->render('banner'));

$layout->setPosition('content','main',[
    'title' => 'Architecto iure labore maxime perferendis',
    'content' => 'Aliquid dolores excepturi expedita illo itaque minus nulla provident quos vitae voluptate? Architecto iure labore maxime perferendis quidem! Ad aliquam minus necessitatibus?',
], function($args) {
    $args['title'] .= ' It`s Append text to title string';
    return $args;
});

$layout->setPosition('footer','layout/footer.php');

$layout->outTemplate();



































/*
$layout->render('navigation','menu', [
    'list' => [],
]);
Layout::value('about_this_page','Lorem ipsum dolor sit amet, consectetur adipisicing elit.');

$layout->render('content','main', [
    'title' => 'Architecto iure labore maxime perferendis',
    'content' => 'Aliquid dolores excepturi expedita illo itaque minus nulla provident quos vitae voluptate? Architecto iure labore maxime perferendis quidem! Ad aliquam minus necessitatibus?',
]);

$part = $layout->part('sidebar', []);
*/