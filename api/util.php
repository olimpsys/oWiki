<?php

require_once './include_dao.php';

function throwError400($error_msg) {

    header('HTTP/1.1 400 Bad Request', true, 400);

    $response = array('error' => $error_msg);

    setJSONResponse($response);

    die;
}

function throwError401($error_msg) {

    header('HTTP/1.1 401 Unauthorized', true, 401);

    $response = array('error' => $error_msg);

    setJSONResponse($response);

    die;
}

function setJSONResponse($response, $encode = true) {
    header('Content-type: application/json');
    echo $encode ? json_encode($response) : $response;
}

function unsetUserFields($user) {
    unset($user->password);
    unset($user->accessToken);
    unset($user->accessTokenExpiration);

    $user->isAdmin = ($user->isAdmin ? true : false);
    $user->isActive = ($user->isActive ? true : false);
}

function getLoggedUser() {
    if (!isset($_COOKIE['accesstoken'])) {
        throw new Exception('accesstoken cookie is mandatory');
    } else {
        $userResult = DAOFactory::getUserDAO()->queryByAccessToken($_COOKIE['accesstoken']);
        if (count($userResult) == 0) {
            throw new Exception('invalid accesstoken');
        } else {
            $user = $userResult[0];

            if (!$user->isActive) {
                throwError400('inactive user');
            } elseif (date('Y-m-d h:i:s') > $user->accessTokenExpiration) {
                throw new Exception('expired accesstoken');
            } else {

                setUserAccessTokenExpiration($user);
                DAOFactory::getUserDAO()->update($user);

                return $user;
            }
        }
    }
}

function setUserAccessTokenExpiration($user) {
    $user->accessTokenExpiration = date('Y-m-d h:i:s', strtotime(date('Y-m-d h:i:s') . ' + 1 day'));
}

function formatPageResponse($page) {
    
    $page->created = new stdClass();
    $page->createdDate = strToJSONDate($page->createdDate);

    $creator = DAOFactory::getUserDAO()->load($page->createdBy);
    if (null !== $creator) {
        $page->created->user = new stdClass();
        $page->created->user->id = $creator->id;
        $page->created->user->name = $creator->name;
    }

    unset($page->createdBy);

    if (null === $page->updatedBy) {
        unset($page->updatedDate);
    } else {
        $page->updated = new stdClass();
        $page->updatedDate = strToJSONDate($page->updatedDate);

        $creator = DAOFactory::getUserDAO()->load($page->updatedBy);
        if (null !== $creator) {
            $page->updated->user = new stdClass();
            $page->updated->user->id = $creator->id;
            $page->updated->user->name = $creator->name;
        }
    }

    unset($page->updatedBy);
    
}

function strToJSONDate($dateStr) {
    return date('c', strtotime($dateStr));
}