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
        if (!$loggedUser->isAdmin) {
            throwError401('user not admin');
        }

        if (!isset($postParams->name)) { //name required
            throwError400('user name required');
        } else if (!isset($postParams->email)) { //name required
            throwError400('user email required');
        } else if (!isset($postParams->password)) { //name required
            throwError400('user password required');
        } else {
            $user = new User();

            checkAndSetFields($loggedUser, $user, $postParams);

            DAOFactory::getUserDAO()->insert($user);
        }
    } else { //update
        if (!$loggedUser->isAdmin && $postParams->id !== $loggedUser->id) {
            throwError401('user not admin');
        }

        $user = checkAndLoadUser($postParams->id);

        checkAndSetFields($loggedUser, $user, $postParams);

        DAOFactory::getUserDAO()->update($user);
    }

    unsetUserFields($user);

    setJSONResponse(array('success' => true, 'user' => $user), true);
} else if ($method == 'GET') { //load
    if (!isset($_GET['id'])) {
        $user = $loggedUser;
    } else {
        $user = checkAndLoadUser($_GET['id']);
    }

    unsetUserFields($user);

    setJSONResponse($user);
}

function checkAndSetFields($loggedUser, $user, $postParams) {

    if (isset($postParams->email) && $user->email !== $postParams->email) {
        if (count(DAOFactory::getUserDAO()->queryByEmail($postParams->email)) > 0) {
            throwError400('user with email already exists');
        } else if (!empty($postParams->email)) {
            $user->email = $postParams->email;
        }
    }

    if (isset($postParams->name) && !empty($postParams->name)) {
        $user->name = $postParams->name;
    }

    if (isset($postParams->password) && !empty($postParams->password)) {
        $user->password = md5($postParams->password);
    }

    if (isset($postParams->isAdmin) && $loggedUser->isAdmin) {
            $user->isAdmin = ($postParams->isAdmin ? 1 : 0);
    }

    if (isset($postParams->isActive)) {
        $user->isActive = ($postParams->isActive ? 1 : 0);
    }
}

function checkAndLoadUser($id) {
    $user = DAOFactory::getUserDAO()->load($id);

    if (!isset($user)) {
        throwError400('user does not exist');
    } else {
        return $user;
    }
}
