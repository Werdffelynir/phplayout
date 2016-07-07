<?php

/**
 * Created by PhpStorm.
 * User: werd
 * Date: 07.07.16
 * Time: 3:15
 */
class Item
{
    /**
     * @var db\SPDO $db
     */
    private $db = null;

    private $table = 'item';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getCategory()
    {
        return $this->db->select('*', $this->table, 'deep = 1');
    }

    public function getSubcategory()
    {
        //return $this->db->select('*', $this->table, 'deep = 2');
    }

    public function getItems()
    {
        //return $this->db->select('*', $this->table, 'deep = 1');
    }


    
}