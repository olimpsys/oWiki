<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	/**
	 * @return CategoryDAO
	 */
	public static function getCategoryDAO(){
		return new CategoryMySqlExtDAO();
	}

	/**
	 * @return PageDAO
	 */
	public static function getPageDAO(){
		return new PageMySqlExtDAO();
	}

	/**
	 * @return UserDAO
	 */
	public static function getUserDAO(){
		return new UserMySqlExtDAO();
	}


}
?>