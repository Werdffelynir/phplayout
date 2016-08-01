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
        $sql = 'SELECT
                      i.*,
                      ip.id as parent_id,
                      ip.title as parent_title,
                      ip.link as parent_link,
                      ipp.id as parent_parent_id,
                      ipp.title as parent_parent_title,
                      ipp.link as parent_parent_link,
                      relp.id as rel_parent_id,
                      relp.type as rel_parent_type,
                      relpp.id as rel_parent_parent_id,
                      relpp.type as rel_parent_parent_type
                    FROM item i
                    LEFT JOIN relation relp ON (relp.child = i.id)
                    LEFT JOIN relation relpp ON (relpp.child = relp.parent)
                    LEFT JOIN item ip ON (ip.id = relp.parent)
                    LEFT JOIN item ipp ON (ipp.id = relpp.parent)
                    WHERE i.link = ?';

        return $this->db->executeOne($sql, $link);
    }

    public function getItemFormatted($link)
    {
        $resultFormatted = [];
        $result = $this->getItem($link);

        if(is_array($result)) {

            foreach ($this->fields as $key) {
                $resultFormatted[$key] = $result[$key];
            }

            if(empty($result['parent_id']) && empty($result['parent_parent_id'])) {
                $resultFormatted['type'] = 'category';

            } else if (empty($result['parent_parent_id'])) {
                $resultFormatted['parent_id'] = $result['parent_id'];
                $resultFormatted['parent_title'] = $result['parent_title'];
                $resultFormatted['parent_link'] = $result['parent_link'];
                $resultFormatted['rel_parent_id'] = $result['rel_parent_id'];
                $resultFormatted['type'] = 'subcategory';
            } else {
                $resultFormatted['parent_id'] = $result['parent_id'];
                $resultFormatted['parent_title'] = $result['parent_title'];
                $resultFormatted['parent_link'] = $result['parent_link'];
                $resultFormatted['parent_parent_id'] = $result['parent_parent_id'];
                $resultFormatted['parent_parent_title'] = $result['parent_parent_title'];
                $resultFormatted['parent_parent_link'] = $result['parent_parent_link'];
                $resultFormatted['rel_parent_id'] = $result['rel_parent_id'];
                $resultFormatted['rel_parent_parent_id'] = $result['rel_parent_parent_id'];
                $resultFormatted['type'] = 'item';
            }
        }

        return empty($resultFormatted) ? null : $resultFormatted;
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