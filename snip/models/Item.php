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
    /**
     * @var string
     */
    private $table = 'item';

    public $fields = [
        'id',
        'deep',
        'link',
        'title',
        'content',
        'created',
        'updated',
        'keyword',
        'description',
        'tags',
    ];

    /**
     * Item constructor.
     * @param PDO $db
     */
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * @return array|bool|int|object
     */
    public function getCategories()
    {
        return $this->db->select('*', $this->table, 'deep = 1');
    }

    public function getCategoriesItems($link)
    {
        $sql = "SELECT ich.*, its.link as parent_link FROM item ich
                LEFT JOIN relation rch ON (rch.child = ich.id)
                LEFT JOIN relation rp ON (rp.child = rch.parent)
                LEFT JOIN item its ON (its.id = rch.parent) 
                LEFT JOIN item itp ON (itp.id = rp.parent) 
                WHERE  itp.link = :link AND itp.deep = 1 AND ich.deep = 3;";

        return $this->db->executeAll($sql, [':link' => $link,]);
    }


    /**
     * @param $parentLink
     * @return mixed
     */
    public function getSubcategories($parentLink)
    {
        return $this->getChildren($parentLink, 1);
    }

    public function getSubcategoriesItems($link)
    {
        $sql = "SELECT ich.*, itp.link as parent_link FROM item ich
                LEFT JOIN relation rp ON (rp.child = ich.id)
                LEFT JOIN item itp ON (itp.id = rp.parent) 
                WHERE  itp.link = :link AND itp.deep = 2 AND ich.deep = 3;";

        return $this->db->executeAll($sql, [':link' => $link,]);
    }

    /**
     * @param $parentLink
     * @return mixed
     */
    public function getItems($parentLink)
    {
        return $this->getChildren($parentLink, 2);
    }

    public function getItem($link)
    {
        return $this->db->select('*', $this->table, 'link = ?', [$link], false);
    }

    public function getItemID($id)
    {
        return $this->db->select('*', $this->table, 'id = ?', [$id], false);
    }

    /**
     * @param $parentLink
     * @param $parentDeep
     * @return mixed
     */
    public function getChildren($parentLink, $parentDeep)
    {
        $sql = "SELECT itch.* FROM item itch
                LEFT JOIN relation r ON (r.child = itch.id)
                LEFT JOIN item itp ON (itp.id = r.parent) 
                WHERE  itp.link = :link AND itp.deep = :deep AND itch.deep = :deep_ch";

        return $this->db->executeAll($sql, [
            ':link' => $parentLink,
            ':deep' => $parentDeep,
            ':deep_ch' => $parentDeep+1,
        ]);
    }




/*
    public function getChildren($link)
    {
        $sql = "SELECT ic.*
                FROM item ic
                LEFT JOIN relation r ON (r.child = ic.id)
                LEFT JOIN item ip ON (ip.id = r.parent)
                WHERE ip.link = :link";

        return $this->db->executeAll($sql, [
            ':link' => $link
        ]);
    }
    */
}