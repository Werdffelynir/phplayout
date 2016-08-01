<?php


/**
 * Created by PhpStorm.
 * User: werd
 * Date: 17.06.16
 * Time: 12:41
 */
class Main
{

    public $isAdmin = true;
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

        $this->Layout->isAdmin = $this->isAdmin;
        $this->Layout->Controller = $this;

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
        $this->Layout->value('url', $this->Router->getUrl());
        $this->Layout->value('urlFull', $this->Router->getFullUrl());
    }


    public function commonLayoutPositions()
    {
        // common views parts
        $categories = $this->modelItem->getCategories();

        $this->Layout
            ->setPosition('navigation', 'navigation', ['categories' => $categories]);
    }

    public function actionIndex()
    {
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar', 'sidebar')
            ->setPosition('content', 'content.index')
            ->outTemplate();
    }

    public function actionCategory($catLink, $subcatLink, $itemLink)
    {
        $item = [];
        $items = [];
        $relations = [];
        $itemsMenu = [];
        $contentPart = 'list';
        $this->Layout->currentAction = [$catLink, $subcatLink, $itemLink];
        $this->Layout->value('currentActionCat', $catLink);
        $this->Layout->value('currentActionSubcat', $subcatLink);
        $this->Layout->value('currentActionItem', $itemLink);

        $this->addFrontend([
            'url' => $this->Router->getUrl(),
            'urlFull' => $this->Router->getFullUrl(),
            'queryCat' => $catLink,
            'querySubcat' => $subcatLink,
            'queryItem' => $itemLink,
        ]);


        if (!empty($itemLink)) {
            $contentPart = 'item';
            $item = $this->modelItem->getItem($itemLink);
            $itemsMenu = $this->modelItem->getChildren($catLink, 1);
            $relations = $this->modelRelation->getRelation($itemLink);
            // ...
            // ...

            //$result = $this->modelItem->getItemFormatted($itemLink);
            //var_dump($result);

            //exit;
            // ...

        }
        else if (!empty($subcatLink)) {
            $item = $this->modelItem->getItem($subcatLink);
            $items = $this->modelItem->getSubcategoriesItems($subcatLink);
            $itemsMenu = $this->modelItem->getChildren($catLink, 1);
            $relations = $this->modelRelation->getRelation($subcatLink);
        }
        else if (!empty($catLink)) {
            $item = $this->modelItem->getItem($catLink);
            $items = $this->modelItem->getCategoriesItems($catLink);
            $itemsMenu = $this->modelItem->getChildren($catLink, 1);
            $relations = $this->modelRelation->getRelation($catLink);
        }

        $this->sendFrontendData();
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('header', 'header', [])
            ->setPosition('sidebar', 'sidebar', [
                'menu' => $this->Layout->render('menu_subcat', [
                    'items' => $itemsMenu,
                ])
            ])
            ->setPosition('content', 'content.'.$contentPart, [
                'item' => $item,
                'items' => $items,
                'relations' => $relations,
            ])
            ->outTemplate();
    }


    public function actionEditor($itemLink)
    {
        $item = array_flip($this->modelItem->fields);
        array_walk($item,function(&$itm){$itm = '';});

        if($itemLink) {
            $this->addFrontend('editMode','update');
            $item = $this->modelItem->getItem($itemLink);
        } else
            $this->addFrontend('editMode','insert');

        $this->sendFrontendData();
        $this->commonLayoutPositions();
        $this->Layout
            ->setPosition('sidebar', 'sidebar')
            ->setPosition('content', 'content.editor', [
                'item'=>$item,
                'relations'=> $this->modelRelation->getRelation($itemLink),
            ])
            ->outTemplate();
    }


    private function sessionToken($token = false)
    {
        return 'secret_session_token_key';
    }

    private $frontendData = [];
/*    public function addFrontend($key, $value = null, $onlyOne = false)
    {
        if(is_array($key) && $onlyOne === false)
            foreach ($key as $k => $v)
                $this->addFrontend($k, $v, true);
        else
            $this->frontendData[$key] = $value;
    }*/
    public function addFrontend($key, $value = null)
    {
        if(is_array($key))
            foreach ($key as $k => $v) $this->addFrontend($k, $v);
        else if(is_string($key))
            $this->frontendData[$key] = $value;
    }
    public function sendFrontendData()
    {
        Helper::cookies('app', json_encode($this->frontendData), 0, '/');
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


    /**
     * Base insert & update work
     * @param $data
     * @return array
     */
    private function api_save($data)
    {
        $item = $current_id = $relations = null;
        $resp = [
            'data' => $data,
            'error' => null,
            'error_info' => null,
            'mode' => '',
            'res_item' => null,
            'res_relations' => [],
        ];


        try{

            $item = json_decode($data['item'], true) ;

            $current_id = isset($item['id'])
                ? $item['id']
                : null;

            $relations = !empty($data['relation'])
                ? json_decode($data['relation'], true)
                : null;

        } catch (Exception $e) {
            $resp['operation_error'] = 'Parse data JSON catch exception: ' . $e->getMessage();
        }


        if($item) {

            $itemData['link'] = trim($item['link']);
            $itemData['title'] = trim($item['title']);
            $itemData['content'] = trim($item['content']);
            $itemData['created'] = date('Y-m-d H:i:s');
            $itemData['updated'] = null;
            $itemData['keyword'] = trim($item['keyword']);
            $itemData['description'] = trim($item['description']);
            $itemData['tags'] = trim($item['tags']);

            if (empty($item['id'])) {

                $resp['mode'] = 'insert';
                $itemData['deep'] = trim($item['deep']);
                $resp['res_item'] = $current_id = $this->db->insert('item', $itemData);
                $resp['res_item_link'] =  $itemData['link'];

                if(!$resp['res_item']) {
                    $resp['error'] = true;
                    $resp['error_info'] = $this->db->getError('error');
                }



            } else {

                $resp['mode'] = 'update';
                $itemData['updated'] = date('Y-m-d H:i:s');
                $result = $this->db->update('item', $itemData, 'id = ?', (int) $item['id']);

                if(!$result) {
                    $resp['error'] = true;
                    $resp['error_info'] = $this->db->getError('error');
                }
                else {

                    $resp['res_item'] = $item['id'];
                    $resp['res_item_link'] = $this->modelItem->getItemID($item['id'])['link'];
                }
            }
        }

        if($relations && $current_id) {
            $relations = array_values($relations);
            foreach ($relations as $rel) {
                $type = $this->modelRelation->getType($item['deep']);
                $resp['res_relations'][] = $this->modelRelation->insertIfNotExist((int)$rel, (int)$current_id, $type);
            }
        }

        return $resp;
    }


    private function api_getcategories($data)
    {
        if(SRouter::isXMLHTTPRequest()) {
            $categories = $this->modelItem->getCategories();

            return [
                'categories' => $categories,
            ];
        }
    }



    private function api_getsubcategories($data)
    {
        if(isset($data['link']) && SRouter::isXMLHTTPRequest()) {
            $subcategories = $this->modelItem->getSubcategories($data['link']);

            return [
                'data' => $data,
                'subcategories' => $subcategories
            ];
        }
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