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

    public function getCategories()
    {
        return $this->db->select('*', $this->table, 'deep = 1');
    }

    public function getSubcategories()
    {
        //return $this->db->select('*', $this->table, 'deep = 2');
    }

    public function getItem($link)
    {
        return $this->db->select('*', $this->table, 'link = ? AND deep = ?', [$link, 3], false);
    }

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
    
}