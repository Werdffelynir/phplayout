<?php

require_once('../src/SLayout.php');
require_once('classes/SRouter.php');
require_once('classes/SPDO.php');
require_once('models/Item.php');
require_once('models/Relation.php');
require_once('controllers/Main.php');

$params = include 'config/main.php';

$SRouter = new SRouter($params['router']);
//$SRouter->forceRun(true);


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
$SRouter->get('/c/:p!', [$Controller,'actionCategory']);
//$SRouter->get('/s/:p!', [$Controller,'actionSubcategory']);
//$SRouter->get('/i/:p!', [$Controller,'actionItem']);
$SRouter->get('/editor/:p?', [$Controller,'actionEditor']);
$SRouter->post('/api', [$Controller,'actionApi']);



/*
args.key = key
args.token = App.token

$SRouter->post('/api/insert', [$Controller,'actionInsert']);
$SRouter->post('/api/update', [$Controller,'actionUpdate']);
$SRouter->post('/api/delete', [$Controller,'actionDelete']);
$SRouter->post('/api/all_category', [$Controller,'actionAllCategories']);
$SRouter->post('/api/all_subcategory/:n!', [$Controller,'actionAllSubcategories']);*/

//$SRouter->get('/c/<category>:a!/<subcategory>:p?', [$Controller,'actionIndex']);













/*
echo '  <a href="'.$R->getUrl().'">home</a>
        <br>
        <a href="'.$R->getUrl('contact').'">contact</a>
        <br>
        <a href="'.$R->getUrl('hello/user').'">hello/user</a>
        <br>
        <a href="'.$R->getUrl('doc/html').'">doc/html</a>
        <br>
        <a href="'.$R->getUrl('doc/php/array_multisort').'">doc/php/array_multisort</a>
        <br>
        <a href="'.$R->getUrl('item/4597548').'">item/4597548</a>
        <br>
        <br>
';



$R->get('/', function(){
    echo "Home page";
});

$R->get('/contact', function(){
    echo "Contact page";
});

$R->get('/hello/<user>:a!', function($user){
    echo "Hello $user";
});

$R->get('/doc/<category>:a!/<subcategory>:p?', function($category, $subcategory){
    echo "Document category: $category, subcategory: $subcategory.";
});

$R->get('/item/:n!', function($id){
    echo "Item ID: $id.";
});
*/

if($errors = $SRouter->getRouterErrors()) {
    var_dump($errors);
    exit;
}

$SRouter->run();