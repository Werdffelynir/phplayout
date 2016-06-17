<?php

require_once('../src/Layout.php');
require_once('classes/SRouter.php');
require_once('classes/SPDO.php');

// if you use multi languages
$RequestURI = trim($_SERVER['REQUEST_URI'],'/');
$lang = 'en';
if(strpos($RequestURI,'/')==2){
    $lang = substr($RequestURI,0,2);
    $RequestURI = substr($RequestURI,3);
}
$config = [
    'base_path'=> 'layout/task',
    'request_uri'=>$RequestURI
];



$R = new SRouter($config);
$R->forceRun(true);



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


if($errors = $R->getRouterErrors())
    print_r($errors);