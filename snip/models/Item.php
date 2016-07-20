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

    /**
     * @param $parentLink
     * @return mixed
     */
    public function getSubcategories($parentLink)
    {
        return $this->getChildren($parentLink, 1);
    }

    /**
     * @param $parentLink
     * @return mixed
     */
    public function getItems($parentLink)
    {
        return $this->getChildren($parentLink, 2);
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
                WHERE  itp.link = :link  AND  itp.deep = :deep";

        return $this->db->executeAll($sql, [
            ':link' => $parentLink,
            ':deep' => $parentDeep,
        ]);
    }


    
}