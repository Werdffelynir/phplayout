<?php

/**
 * Created by PhpStorm.
 * User: werd
 * Date: 17.06.16
 * Time: 12:41
 */
class Main
{
    /**
     * @var SRouter
     */
    public $Router = null;
    /**
     * @var SLayout
     */
    public $Layout = null;
    /**
     * @var \db\SPDO
     */
    public $DB = null;

    public function __construct($SRouter, $SLayout, $SPDO)
    {
        $this->Router = $SRouter;
        $this->Layout = $SLayout;
        $this->DB = $SPDO;
    }

    public function actionIndex()
    {

        $this->Layout
            ->setPosition('menu','menu')
            ->setPosition('content','content')
            ->setPosition('editor','content.editor')
            ->outTemplate();
    }

    public function actionCategory()
    {

    }

    public function actionItem()
    {

    }

}