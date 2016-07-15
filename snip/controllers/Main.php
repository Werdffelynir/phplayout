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
        //$this->dbFilePermissions($params);

        $this->params = $params;
        $this->Router = $SRouter;
        $this->Layout = $SLayout;
        $this->db = $SPDO;

        $this->modelItem = new Item($this->db);
        $this->modelRelation = new Relation($this->db);

        $this->commonLayoutVariables();
    }

    private function dbFilePermissions($params)
    {
        $path = implode('',array_slice(explode(':', $params['db']['dsn']), 1));
        if(is_file($path)) {
            $permission = substr(sprintf('%o', fileperms($path)), -4);
            if(is_numeric($permission) && $permission != '0777') {
                chmod($path, 0777);
                chown($path, $params['filesystem_owner']);
            }
        }
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
            ->setPosition('navigation', 'navigation', ['categories' => $categories])
            ->setPosition('header', 'header', []);
    }

    public function actionIndex()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar', 'sidebar')
            ->setPosition('content', 'content.index')
            ->outTemplate();
    }

    public function actionCategory()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar', 'sidebar')
            ->setPosition('content', 'content.category')
            ->outTemplate();
    }

    public function actionEditor()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar', 'sidebar')
            ->setPosition('content', 'content.editor')
            ->outTemplate();
    }


    private function sessionToken($token = false)
    {
        return 'secret_session_token_key';
    }

    /*   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *
     *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *
     *   *   *   *   *   *   *   *   AJAX  API   *   *   *   *   *   *   *   *
     *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *
     *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   *   */

    /**
     * Base Api controller
     */
    public function actionApi()
    {
        if (SRouter::isXMLHTTPRequest() && (!empty($_POST['key']) || !empty($_POST['token']))) {

            $key = trim($_POST['key']);
            $token = trim($_POST['token']);
            $apiData = $_POST;

            unset($apiData['key']);
            unset($apiData['token']);

            $data['data'] = call_user_func([$this, "api_$key"], $apiData);
            $data['token'] = $this->sessionToken($token);

            exit(json_encode($data));
        }
    }


    private function api_save($data)
    {
        $item = null;
        $resp = [
            'data' => $data,
            'operation' => '',
            'operation_result' => false,
        ];

        try{

            $item = json_decode($data['item'], true) ;

            $relation = !empty($data['relation'])
                ? json_decode($data['relation'], true)
                : false;

        }catch (Exception $e) {
            $resp['operation_error'] = 'POST data not parse in type JSON. Exception: ' . $e->getMessage();
        }


//        $resp['item'] = $item;
//        $resp['relation'] = $relation;
//        return $resp;
        if($item) {

            $itemData['deep'] = trim($item['deep']);
            $itemData['link'] = trim($item['link']);
            $itemData['title'] = trim($item['title']);
            $itemData['content'] = trim($item['content']);
            $itemData['created'] = date('d.m.Y H:i:s');
            $itemData['keyword'] = trim($item['keyword']);
            $itemData['description'] = trim($item['description']);
            $itemData['tags'] = trim($item['tags']);

            $resp['itemData'] = $itemData;

            if (empty($data['id'])) {

                $resp['operation'] = 'insert';
                $result = $this->db->insert('item', $itemData);

                if($result) $resp['operation_result'] = $this->db->lastInsertId();
                else $resp['operation_error'] = $this->db->getError('error');

            } else {
                $resp['operation'] = 'update';
                $result = $this->db->update('item', $itemData, 'id = ?', (int) $data['id']);
                $resp['operation_result'] = $result ? $result : $this->db->errorInfo();
            }
        }



        return $resp;
    }


    private function api_getcategories($data)
    {
        $categories = $this->modelItem->getCategories();

        return [
            'categories' => $categories,
        ];
    }



    private function api_getsubcategories($data)
    {
        $categories = $this->modelItem->getCategories();
        $responseData = [
            'data' => $data
        ];

        return $responseData;
    }






    /*
     * args.key = key
args.token = App.token
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