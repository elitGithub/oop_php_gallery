<?php

require_once '../../includes/init.php';
use Gallery\Users;
use Gallery\Utils;

$users = new Users();

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['create_user'])) {
    foreach ($_POST['update_user'] as $key => $value) {
        if (!in_array($key, $users->entityDataColumns)) {
            Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
        }
    }
    $filterArgs = [
        'update_user' => ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FORCE_ARRAY],
        'user_id' => FILTER_VALIDATE_INT
    ];
    $data = filter_var_array($_POST, $filterArgs);
    $users->insert($data);
    if ($users->lastInsertId()) {
        Utils::sendFinalResponseAsJson(true, "", []);
    }
    Utils::sendFinalResponseAsJson(false, 'Could not insert new user', $users->retrieveError());
}
