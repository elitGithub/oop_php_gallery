<?php
require_once '../../includes/init.php';
use Gallery\Users;
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$users = new Users();
$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['update_user'])) {
    foreach ($_POST['update_user'] as $key => $value) {
        if (!in_array($key, $users->entityDataColumns)) {
            die(@json_encode(['success' => false, 'message' => "Unrecognized column {$key} in request", 'data' => []]));
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
    }
    if ($users->countAffectedRows() === 1) {
        die(@json_encode(['success' => true, 'message' => "", 'data' => []]));
    }
    die(@json_encode(['success' => false, 'message' => "Nothing was changed", 'data' => ['errors' => $users->retrieveError()]]));
}