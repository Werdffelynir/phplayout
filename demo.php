<?php

include 'Layout.php';

$config = [
    'path' => __DIR__.'/views/',
    'template' => 'layout/template',
];


$layout = new Layout($config);
$layout->render('header','layout/header.php');
$layout->render('navigation','layout/navigation.php');

$layout->render('content','main',[
    'title' => 'Architecto iure labore maxime perferendis',
    'content' => 'Aliquid dolores excepturi expedita illo itaque minus nulla provident quos vitae voluptate? Architecto iure labore maxime perferendis quidem! Ad aliquam minus necessitatibus?',
]);



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





$layout->outputTemplate();
