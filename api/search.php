<?php

require_once './include_dao.php';
require_once './util.php';

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

$searchResults = DAOFactory::getPageDAO()->searchPages($_GET['query']);

foreach ($searchResults as $page) {

    formatPageResponse($page);

    $text = strip_tags($page->content);
    $pos = stripos($text, $_GET['query']);
    $limit = 200;
    $shortContent = html_entity_decode(substr($text, max(0, ($pos - $limit)), min(strlen($text), ($pos + $limit))));
    $page->shortContent = $shortContent;

    unset($page->content);
}

setJSONResponse(array('results' => $searchResults));
