<?php

require_once './include_dao.php';
require_once './util.php';

try {
    $loggedUser = getLoggedUser();
} catch (Exception $ex) {
    throwError401($ex->getMessage());
}

$users = DAOFactory::getUserDAO()->queryAllOrderBy('name');

foreach ($users as $user) {
    unsetUserFields($user);
}

setJSONResponse(array('users' => $users), true);
