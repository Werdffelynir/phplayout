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

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }




}