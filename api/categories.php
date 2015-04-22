<?php

require_once './include_dao.php';
require_once './util.php';

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

if (!isset($_GET['output'])) {
    $categories = DAOFactory::getCategoryDAO()->queryAllOrderBy('name');
} else if ($_GET['output'] == 'rootOnly') {
    $categories = DAOFactory::getCategoryDAO()->queryAllRootOrderBy('name');
} else if ($_GET['output'] == 'nested') {

    $categories = DAOFactory::getCategoryDAO()->queryAllRootOrderBy('name');

    foreach ($categories as $category) {
        setSubCategories($category);
    }
}

setJSONResponse(array('categories' => $categories), true);

// functions -------------------------------------------------------------------

function setSubCategories($category) {
    $categories = DAOFactory::getCategoryDAO()->queryByParent($category->id);
    $category->categories = $categories;
    
    foreach ($categories as $category) {
        setSubCategories($category);
    }
}
