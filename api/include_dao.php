<?php
	//include all DAO files
	require_once('class/sql/Connection.class.php');
	require_once('class/sql/ConnectionFactory.class.php');
	require_once('class/sql/ConnectionProperty.class.php');
	require_once('class/sql/QueryExecutor.class.php');
	require_once('class/sql/Transaction.class.php');
	require_once('class/sql/SqlQuery.class.php');
	require_once('class/core/ArrayList.class.php');
	require_once('class/dao/DAOFactory.class.php');
 	
	require_once('class/dao/CategoryDAO.class.php');
	require_once('class/dto/Category.class.php');
	require_once('class/mysql/CategoryMySqlDAO.class.php');
	require_once('class/mysql/ext/CategoryMySqlExtDAO.class.php');
	require_once('class/dao/PageDAO.class.php');
	require_once('class/dto/Page.class.php');
	require_once('class/mysql/PageMySqlDAO.class.php');
	require_once('class/mysql/ext/PageMySqlExtDAO.class.php');
	require_once('class/dao/UserDAO.class.php');
	require_once('class/dto/User.class.php');
	require_once('class/mysql/UserMySqlDAO.class.php');
	require_once('class/mysql/ext/UserMySqlExtDAO.class.php');

?>