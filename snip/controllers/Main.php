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
    public $db = null;

    public function __construct($SRouter, $SLayout, $SPDO)
    {
        $this->Router = $SRouter;
        $this->Layout = $SLayout;
        $this->db = $SPDO;
    }

    public function actionIndex()
    {

        $this->Layout
            ->setPosition('menu','menu')
            ->setPosition('content','content')
            ->setPosition('editor','content.editor')
            ->outTemplate();
    }

    public function actionInsert()
    {
        $response = [
            'data' => null,
            'error' => null,
            'result' => null,
        ];
        try{
            //"link":"PHP","tags":"","keyword":"","description":"","type":"subcategory","title":"PHP","content":"PHP Code Snippets"}
            $data['type'] = trim($_POST['type']);
            $data['title'] = trim($_POST['title']);
            $data['content'] = trim($_POST['content']);
            $data['link'] = trim($_POST['link']);
            $data['tags'] = trim($_POST['tags']);
            $data['description'] = trim($_POST['description']);
            $data['created'] = time();

            $result = $this->db->insert('article', $data);

            if($error = $this->db->getError()){
                $response['error'] = $error['error'];
                $response['error_sql'] = $error['sql'];
            }else
                $response['result'] = $result;

        }catch(Exception $e) {
            $response['error'] = 'Error on try parse POST data ';
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

}