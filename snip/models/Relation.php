<?php

/**
 * Created by PhpStorm.
 * User: werd
 * Date: 07.07.16
 * Time: 3:16
 */
class Relation
{
    /**
     * @var db\SPDO $db
     */
    private $db = null;
    private $table = 'relation';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }


    public function getRelation($itemLink)
    {
        $sql = "SELECT 
                r.* , 
                ip.id AS itemp_id,
                ip.link AS itemp_link,
                ip.title AS itemp_title, 
                ipp.id AS itempp_id,
                ipp.link AS itempp_link,
                ipp.title AS itempp_title
                FROM relation r
                LEFT JOIN item i ON (i.id = r.child) 
                LEFT JOIN item ip ON (ip.id = r.parent) 
                LEFT JOIN relation rp ON (rp.child = r.parent) 
                LEFT JOIN item ipp ON (ipp.id = rp.parent) 
                WHERE i.link = ?";

        return $this->db->executeAll($sql, $itemLink);
    }


    /**
     * @param $parent
     * @param $child
     * @param $type
     * @return int|null
     */
    public function insertIfNotExist($parent, $child, $type)
    {
        $result = null;

        $exist = $this->db->select('*', $this->table, 'parent = :parent AND child = :child', [
            ':parent' => $parent,
            ':child' => $child,
        ]);


        if(!$exist) {

            $result = $this->db->insert( $this->table , [
                'parent' => $parent,
                'child' => $child,
                'type' => $type,
            ]);

        } else {
            return $exist;
        }

        return $result;
    }

    public function getType($deep)
    {
        $tbl[0] = 'undefined';
        $tbl[1] = 'category';
        $tbl[2] = 'subcategory';
        $tbl[3] = 'item';
        return $tbl[(int)$deep];
    }



}