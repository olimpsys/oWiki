<?php
/**
 * Class that operate on table 'page'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-04-21 16:26
 */
class PageMySqlDAO implements PageDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return PageMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM page WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM page';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM page ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param page primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM page WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param PageMySql page
 	 */
	public function insert($page){
		$sql = 'INSERT INTO page (title, content, category_id, created_by, created_date, updated_by, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($page->title);
		$sqlQuery->set($page->content);
		$sqlQuery->setNumber($page->categoryId);
		$sqlQuery->setNumber($page->createdBy);
		$sqlQuery->set($page->createdDate);
		$sqlQuery->setNumber($page->updatedBy);
		$sqlQuery->set($page->updatedDate);

		$id = $this->executeInsert($sqlQuery);	
		$page->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param PageMySql page
 	 */
	public function update($page){
		$sql = 'UPDATE page SET title = ?, content = ?, category_id = ?, created_by = ?, created_date = ?, updated_by = ?, updated_date = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($page->title);
		$sqlQuery->set($page->content);
		$sqlQuery->setNumber($page->categoryId);
		$sqlQuery->setNumber($page->createdBy);
		$sqlQuery->set($page->createdDate);
		$sqlQuery->setNumber($page->updatedBy);
		$sqlQuery->set($page->updatedDate);

		$sqlQuery->setNumber($page->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM page';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByTitle($value){
		$sql = 'SELECT * FROM page WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByContent($value){
		$sql = 'SELECT * FROM page WHERE content = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCategoryId($value){
		$sql = 'SELECT * FROM page WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedBy($value){
		$sql = 'SELECT * FROM page WHERE created_by = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByCreatedDate($value){
		$sql = 'SELECT * FROM page WHERE created_date = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedBy($value){
		$sql = 'SELECT * FROM page WHERE updated_by = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUpdatedDate($value){
		$sql = 'SELECT * FROM page WHERE updated_date = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByTitle($value){
		$sql = 'DELETE FROM page WHERE title = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByContent($value){
		$sql = 'DELETE FROM page WHERE content = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCategoryId($value){
		$sql = 'DELETE FROM page WHERE category_id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedBy($value){
		$sql = 'DELETE FROM page WHERE created_by = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByCreatedDate($value){
		$sql = 'DELETE FROM page WHERE created_date = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedBy($value){
		$sql = 'DELETE FROM page WHERE updated_by = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUpdatedDate($value){
		$sql = 'DELETE FROM page WHERE updated_date = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return PageMySql 
	 */
	protected function readRow($row){
		$page = new Page();
		
		$page->id = $row['id'];
		$page->title = $row['title'];
		$page->content = $row['content'];
		$page->categoryId = $row['category_id'];
		$page->createdBy = $row['created_by'];
		$page->createdDate = $row['created_date'];
		$page->updatedBy = $row['updated_by'];
		$page->updatedDate = $row['updated_date'];

		return $page;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return PageMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>