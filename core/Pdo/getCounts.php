<?php
/**
 * Created by PhpStorm.
 * User: valik
 * Date: 23.01.2017
 * Time: 14:17
 */

namespace Pdo;


use Exception\BadRequestException;


class GetCounts
{

    private $res, $counts_count;
    private $name_counter;
    private $_pdo;

    function __construct($param)
    {
        $this->_pdo = \db::getLink()->getDb();
        $sq = "SELECT c.id, c.n_counter, c.name FROM  count AS c WHERE (c.id = :id);";
        $this->res = $this->_pdo->prepare($sq);
        if (!$this->res->execute($param)) {
            throw new \Exception($this->_pdo->errorInfo()[2]);
        }
        $count = $this->res->fetchAll();
        if (empty($count)) {
            throw new BadRequestException('Count not found!');
        } else {
            $counts_count = $count[0];
                $this->name_counter = $counts_count['name'];
                unset ($counts_count['name']);
            $this->counts_count = $counts_count;
        }

    }

    public function getCount()
    {
        return $this->counts_count;
    }

    public function getName()
    {
        return $this->name_counter;
    }

}