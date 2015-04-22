<?php

require_once './include_dao.php';
require_once './util.php';

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') { //create or update
    $postParams = json_decode(file_get_contents('php://input'));

    if (!isset($postParams->id)) { //create
        if (!isset($postParams->name)) { //name required
            throwError400('category name required');
        } else {

            $category = new Category();
            $category->name = $postParams->name;

            checkAndSetParent($category, $postParams);

            DAOFactory::getCategoryDAO()->insert($category);

            setJSONResponse(array('success' => true, 'category' => $category), true);
        }
    } else {
        if (isset($postParams->deleteCategory)) { //delete
            $categories = DAOFactory::getCategoryDAO()->queryByParent($postParams->id);

            foreach ($categories as $category) {
                deleteSubCategoriesAndPages($category);
            }

            //delete pages
            DAOFactory::getPageDAO()->deleteByCategoryId($postParams->id);

            //delete sub categories
            DAOFactory::getCategoryDAO()->deleteByParent($postParams->id);

            //delete category
            DAOFactory::getCategoryDAO()->delete($postParams->id);

            setJSONResponse(array('success' => true), true);
        } else { //update
            $category = checkAndLoadCategory($postParams->id);
            if (isset($postParams->name)) {
                $category->name = $postParams->name;
            }
            checkAndSetParent($category, $postParams);

            DAOFactory::getCategoryDAO()->update($category);

            setJSONResponse(array('success' => true, 'category' => $category), true);
        }
    }
} else if ($method == 'GET') { //load
    if (!isset($_GET['id'])) {
        throwError400('Category id mandatory');
    } else {

        $category = checkAndLoadCategory($_GET['id']);

        $subcategories = DAOFactory::getCategoryDAO()->queryByParent($category->id);
        $category->categories = $subcategories;

        $pages = DAOFactory::getPageDAO()->queryByCategoryId($category->id);
        $category->pages = $pages;

        setJSONResponse($category);
    }
}

// functions -------------------------------------------------------------------

function checkAndSetParent($category, $postParams) {
    if (isset($postParams->parent)) {
        if ($category->id == $postParams->parent) {
            throwError400('cannot set current category as parent of itself');
        } else if (null === DAOFactory::getCategoryDAO()->load($postParams->parent)) {
            throwError400('parent category does not exist');
        } else {
            $category->parent = $postParams->parent;
        }
    }
}

function checkAndLoadCategory($id) {
    $category = DAOFactory::getCategoryDAO()->load($id);

    if (!isset($category)) {
        throwError400('category does not exist');
    } else {
        return $category;
    }
}

function deleteSubCategoriesAndPages($category) {
    $categories = DAOFactory::getCategoryDAO()->queryByParent($category->id);

    //delete pages
    DAOFactory::getPageDAO()->deleteByCategoryId($category->id);

    //delete sub categories
    DAOFactory::getCategoryDAO()->deleteByParent($category->id);

    //delete category
    DAOFactory::getCategoryDAO()->delete($category->id);

    foreach ($categories as $category) {
        deleteSubCategoriesAndPages($category);
    }
}
