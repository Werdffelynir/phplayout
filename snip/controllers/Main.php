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
     * @var array|null
     */
    public $params = null;
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
    public $db = null;
    /**
     * @var Item|null
     */
    public $modelItem = null;
    /**
     * @var null|Relation
     */
    public $modelRelation = null;

    /**
     * Main constructor.
     * @param array $params
     * @param SRouter $SRouter
     * @param SLayout $SLayout
     * @param db\SPDO $SPDO
     */
    public function __construct($params, $SRouter, $SLayout, $SPDO)
    {
        $this->params = $params;
        $this->Router = $SRouter;
        $this->Layout = $SLayout;
        $this->db = $SPDO;

        $this->modelItem = new Item($this->db);
        $this->modelRelation = new Relation($this->db);

        $this->commonLayoutVariables();
    }


    public function commonLayoutVariables()
    {
        // bases layout variables
        $this->Layout->Controller = $this;
        $this->Layout->value('url', $this->Router->getUrl());
        $this->Layout->value('urlFull', $this->Router->getFullUrl());
    }


    public function commonLayoutPositions()
    {
        // common views parts
        $categories = $this->modelItem->getCategories();

        $this->Layout
            ->setPosition('navigation','navigation', ['categories'=>$categories])
            ->setPosition('header','header',[]);
    }

    public function actionIndex()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar','sidebar')
            ->setPosition('content','content.index')
            ->outTemplate();
    }

    public function actionCategory()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar','sidebar')
            ->setPosition('content','content.category')
            ->outTemplate();
    }

    public function actionEditor()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar','sidebar')
            ->setPosition('content','content.editor')
            ->outTemplate();
    }


















/*
    public function actionInsert()
    {
        $response = [
            'data' => null,
            'error' => null,
            'result' => null,
        ];
        try{
            $data['deep'] = trim($_POST['deep']);
            $data['link'] = trim($_POST['link']);
            $data['title'] = trim($_POST['title']);
            $data['content'] = trim($_POST['content']);
            $data['created'] = time();
            $data['keyword'] = trim($_POST['keyword']);
            $data['description'] = trim($_POST['description']);
            $data['tags'] = trim($_POST['tags']);

            $result = $this->db->insert('item', $data);

            if($error = $this->db->getError()){
                $response['error'] = $error['error'];
                $response['error_sql'] = $error['sql'];
            }else
                $response['result'] = $result;

        }catch(Exception $e) {
            $response['error'] = '"InsertItem" Error - try parse POST data ';
        }

        print_r(json_encode($response));
        exit;
    }

    public function actionInsertRelation()
    {
        $response = [
            'data' => null,
            'error' => null,
            'result' => null,
        ];
        try{
            $data['parent'] = (int)trim($_POST['parent']);
            $data['child'] = (int)trim($_POST['child']);

            $result = $this->db->insert('relation', $data);

            if($error = $this->db->getError()){
                $response['error'] = $error['error'];
                $response['error_sql'] = $error['sql'];
            }else
                $response['result'] = $result;

        }catch(Exception $e) {
            $response['error'] = '"InsertRelation" Error - try parse POST data ';
        }

        print_r(json_encode($response));
        exit;
    }



    public function actionUpdate()
    {
        echo 'Hello Update';

        exit;
    }

    public function actionDelete()
    {
        echo 'Hello';

        exit;
    }

    public function actionCategory()
    {

    }

    public function actionItem()
    {

    }

    public function actionAllSubcategories($parent)
    {
        $response = [
            'result' => null,
            'error' => null,
        ];

        $result = $this->actionGetAllByDeep((int) $parent);

        if($result)
            $response['result'] = $result;
        else if($error = $this->db->getError()) {
            $response['error'] = $error['error'];
            $response['error_sql'] = $error['sql'];
        }

        print_r(json_encode($response));
        exit;
    }

    public function actionAllCategories()
    {
        $response = [
            'result' => null,
            'error' => null,
        ];

        $result = $this->actionGetAllByDeep(1);

        if($result)
            $response['result'] = $result;
        else if($error = $this->db->getError()) {
            $response['error'] = $error['error'];
            $response['error_sql'] = $error['sql'];
        }

        print_r(json_encode($response));
        exit;
    }

    public function actionGetAllByDeep($deep)
    {
        return $this->db->select('*', 'item', 'deep = ?', [(int)$deep]);
    }*/
}