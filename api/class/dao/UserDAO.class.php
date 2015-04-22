<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-04-21 16:26
 */
interface UserDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return User 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param user primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param User user
 	 */
	public function insert($user);
	
	/**
 	 * Update record in table
 	 *
 	 * @param User user
 	 */
	public function update($user);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByName($value);

	public function queryByEmail($value);

	public function queryByPassword($value);

	public function queryByIsAdmin($value);

	public function queryByIsActive($value);

	public function queryByAccessToken($value);

	public function queryByAccessTokenExpiration($value);


	public function deleteByName($value);

	public function deleteByEmail($value);

	public function deleteByPassword($value);

	public function deleteByIsAdmin($value);

	public function deleteByIsActive($value);

	public function deleteByAccessToken($value);

	public function deleteByAccessTokenExpiration($value);


}
?>