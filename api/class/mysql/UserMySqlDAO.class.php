<?php
/**
 * Class that operate on table 'user'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2015-04-21 16:26
 */
class UserMySqlDAO implements UserDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UserMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM user WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM user';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM user ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param user primary key
 	 */
	public function delete($id){
		$sql = 'DELETE FROM user WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UserMySql user
 	 */
	public function insert($user){
		$sql = 'INSERT INTO user (name, email, password, is_admin, is_active, access_token, access_token_expiration) VALUES (?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($user->name);
		$sqlQuery->set($user->email);
		$sqlQuery->set($user->password);
		$sqlQuery->setNumber($user->isAdmin);
		$sqlQuery->setNumber($user->isActive);
		$sqlQuery->set($user->accessToken);
		$sqlQuery->set($user->accessTokenExpiration);

		$id = $this->executeInsert($sqlQuery);	
		$user->id = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UserMySql user
 	 */
	public function update($user){
		$sql = 'UPDATE user SET name = ?, email = ?, password = ?, is_admin = ?, is_active = ?, access_token = ?, access_token_expiration = ? WHERE id = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($user->name);
		$sqlQuery->set($user->email);
		$sqlQuery->set($user->password);
		$sqlQuery->setNumber($user->isAdmin);
		$sqlQuery->setNumber($user->isActive);
		$sqlQuery->set($user->accessToken);
		$sqlQuery->set($user->accessTokenExpiration);

		$sqlQuery->setNumber($user->id);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM user';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByName($value){
		$sql = 'SELECT * FROM user WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByEmail($value){
		$sql = 'SELECT * FROM user WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByPassword($value){
		$sql = 'SELECT * FROM user WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsAdmin($value){
		$sql = 'SELECT * FROM user WHERE is_admin = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByIsActive($value){
		$sql = 'SELECT * FROM user WHERE is_active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAccessToken($value){
		$sql = 'SELECT * FROM user WHERE access_token = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByAccessTokenExpiration($value){
		$sql = 'SELECT * FROM user WHERE access_token_expiration = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByName($value){
		$sql = 'DELETE FROM user WHERE name = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByEmail($value){
		$sql = 'DELETE FROM user WHERE email = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByPassword($value){
		$sql = 'DELETE FROM user WHERE password = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsAdmin($value){
		$sql = 'DELETE FROM user WHERE is_admin = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByIsActive($value){
		$sql = 'DELETE FROM user WHERE is_active = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAccessToken($value){
		$sql = 'DELETE FROM user WHERE access_token = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByAccessTokenExpiration($value){
		$sql = 'DELETE FROM user WHERE access_token_expiration = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UserMySql 
	 */
	protected function readRow($row){
		$user = new User();
		
		$user->id = $row['id'];
		$user->name = $row['name'];
		$user->email = $row['email'];
		$user->password = $row['password'];
		$user->isAdmin = $row['is_admin'];
		$user->isActive = $row['is_active'];
		$user->accessToken = $row['access_token'];
		$user->accessTokenExpiration = $row['access_token_expiration'];

		return $user;
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
	 * @return UserMySql 
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