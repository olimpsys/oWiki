<?php

require_once './include_dao.php';
require_once './util.php';

$method = $_SERVER['REQUEST_METHOD'];

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

if ($method == 'POST') { //create or update
    $postParams = json_decode(file_get_contents('php://input'));

    if (!isset($postParams->id)) { //create
        if (!isset($postParams->title)) { //title required
            throwError400('page title required');
        } else if (!isset($postParams->categoryId)) { //title required
            throwError400('category id required');
        } else {

            $page = new Page();
            $page->title = $postParams->title;
            $page->content = $postParams->content;
            $page->createdBy = $loggedUser->id;
            $page->createdDate = date('Y-m-d h:i:s');

            checkAndSetCategory($page, $postParams);

            DAOFactory::getPageDAO()->insert($page);

            setJSONResponse(array('success' => true, 'page' => $page), true);
        }
    } else {
        if (isset($postParams->deletePage)) { //delete
            
            DAOFactory::getPageDAO()->delete($postParams->id);
            
            setJSONResponse(array('success' => true), true);
            
        } else { //update
            $page = checkAndLoadPage($postParams->id);
            if (isset($postParams->title)) {
                $page->title = $postParams->title;
            }
            if (isset($postParams->content)) {
                $page->content = $postParams->content;
            }
            $page->updatedBy = $loggedUser->id;
            $page->updatedDate = date('Y-m-d h:i:s');

            checkAndSetCategory($page, $postParams);

            DAOFactory::getPageDAO()->update($page);

            setJSONResponse(array('success' => true, 'page' => $page), true);
        }
    }
} else if ($method == 'GET') { //load
    if (!isset($_GET['id'])) {
        throwError400('Page id mandatory');
    } else {

        $page = checkAndLoadPage($_GET['id']);

        formatPageResponse($page);

        setJSONResponse($page);
    }
}

// functions -------------------------------------------------------------------

function checkAndSetCategory($page, $postParams) {
    if (isset($postParams->categoryId)) {
        if (null === DAOFactory::getCategoryDAO()->load($postParams->categoryId)) {
            throwError400('category does not exist');
        } else {
            $page->categoryId = $postParams->categoryId;
        }
    }
}

function checkAndLoadPage($id) {
    $page = DAOFactory::getPageDAO()->load($id);

    if (!isset($page)) {
        throwError400('page does not exist');
    } else {
        return $page;
    }
}
