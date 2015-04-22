<?php

require_once './include_dao.php';
require_once './util.php';

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

$recentPages = DAOFactory::getPageDAO()->getRecentPages();

foreach ($recentPages as $page) {

    formatPageResponse($page);
    unset($page->content);
    
}

setJSONResponse(array('recentPages' => $recentPages));
