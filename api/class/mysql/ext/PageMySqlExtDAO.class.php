<?php

/**
 * Class that operate on table 'page'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-04-19 17:49
 */
class PageMySqlExtDAO extends PageMySqlDAO {

    public function getRecentPages($limit = 5) {
        $sql = 'SELECT * FROM page ORDER BY created_date DESC, updated_date DESC LIMIT ' . $limit;
        $sqlQuery = new SqlQuery($sql);
        return $this->getList($sqlQuery);
    }
    
    public function searchPages($searchQuery) {
        $sql = 'SELECT * FROM page WHERE content LIKE ? OR title LIKE ? ORDER BY created_date DESC, updated_date DESC LIMIT 1000';
        $sqlQuery = new SqlQuery($sql);
        $sqlQuery->setString('%' . $searchQuery . '%');
        $sqlQuery->setString('%' . $searchQuery . '%');
        return $this->getList($sqlQuery);
    }

}

?>