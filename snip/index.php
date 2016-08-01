<?php

require_once('../src/SLayout.php');
require_once('classes/Helper.php');
require_once('classes/SRouter.php');
require_once('classes/SPDO.php');
require_once('classes/Parsedown.php');
require_once('models/Item.php');
require_once('models/Relation.php');
require_once('controllers/Main.php');

$params = include 'config/main.php';
$SRouter = new SRouter($params['router']);

/**
 * Work with templates
 */
$SLayout = new SLayout();

/**
 * Work with database
 */
$SPDO = new \db\SPDO($params['db']['dsn']);

/**
 * Base controller
 */
$Controller = new Main($params, $SRouter, $SLayout, $SPDO);

$SRouter->get('/', [$Controller,'actionIndex']);
$SRouter->get('/q/:p!/:p?/:p?', [$Controller,'actionCategory']);
$SRouter->get('/editor/:p?', [$Controller,'actionEditor']);
$SRouter->post('/api', [$Controller,'actionApi']);
$SRouter->map('POST|GET', '/auth/:p?', [$Controller,'actionAuth']);

if($errors = $SRouter->getRouterErrors()) {
    var_dump($errors);
    exit;
}

$SRouter->run();