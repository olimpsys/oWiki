<?php

require_once './include_dao.php';
require_once './util.php';

$postParams = json_decode(file_get_contents('php://input'));

if (!isset($postParams->email) || !isset($postParams->password)) {
    throwError400('email and password required');
} else {
    $userResult = DAOFactory::getUserDAO()->queryByEmail($postParams->email);

    if (count(DAOFactory::getUserDAO()->queryByEmail($postParams->email)) == 0) {
        throwError400('user does not exist');
    } else {

        $user = $userResult[0];

        if (!$user->isActive) {
            throwError400('inactive user');
        } else if ($user->password !== md5($postParams->password)) {
            throwError400('password invalid');
        } else {
            if (date('Y-m-d h:i:s') > $user->accessTokenExpiration) {
                $user->accessToken = md5(uniqid());
            }
            setUserAccessTokenExpiration($user);

            DAOFactory::getUserDAO()->update($user);

            setJSONResponse(array('accesstoken' => $user->accessToken), true);
        }
    }
}
