<?php
require_once '../../includes/init.php';
use Gallery\Users;
use Gallery\Utils;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$users = new Users();
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['update_user'])) {
    foreach ($_POST['update_user'] as $key => $value) {
        if (!in_array($key, $users->entityDataColumns)) {
            Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
        }
    }
    $filterArgs = [
        'update_user' => ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FORCE_ARRAY],
        'user_id' => FILTER_VALIDATE_INT
    ];
    $post = filter_var_array($_POST, $filterArgs);
    $user = $users->findOne($post['user_id']);

    $diff = array_diff($user, $post['update_user']);
    $diff = array_diff(array_keys($diff), Users::EXCLUDED_FIELDS);
    if (sizeof($diff) > 0) {
        $users->updateOne($post['user_id'], $post['update_user']);
        if ($users->countAffectedRows() === 1) {
            Utils::sendFinalResponseAsJson(true, '', []);
        }
    }
    Utils::sendFinalResponseAsJson(false, 'Nothing was changed', ['errors' => $users->retrieveError()]);
}

Utils::sendFinalResponseAsJson(false, 'No post data!', ['errors' => $_POST]);