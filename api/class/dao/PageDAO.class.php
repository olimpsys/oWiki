<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2015-04-21 16:26
 */
interface PageDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Page 
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
 	 * @param page primary key
 	 */
	public function delete($id);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Page page
 	 */
	public function insert($page);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Page page
 	 */
	public function update($page);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByTitle($value);

	public function queryByContent($value);

	public function queryByCategoryId($value);

	public function queryByCreatedBy($value);

	public function queryByCreatedDate($value);

	public function queryByUpdatedBy($value);

	public function queryByUpdatedDate($value);


	public function deleteByTitle($value);

	public function deleteByContent($value);

	public function deleteByCategoryId($value);

	public function deleteByCreatedBy($value);

	public function deleteByCreatedDate($value);

	public function deleteByUpdatedBy($value);

	public function deleteByUpdatedDate($value);


}
?>