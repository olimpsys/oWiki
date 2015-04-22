<?php

/**
 * Class that operate on table 'category'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-04-19 17:49
 */
class CategoryMySqlExtDAO extends CategoryMySqlDAO {

    public function queryAllRootOrderBy($orderColumn) {
        $sql = 'SELECT * FROM category WHERE parent IS NULL ORDER BY ' . $orderColumn;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }

}

?>