<?php

require_once '../../includes/init.php';
use Gallery\Users;

$users = new Users();

$_POST = json_decode(file_get_contents('php://input'), true);

if (isset($_POST['create_user'])) {
    foreach ($_POST['update_user'] as $key => $value) {
        if (!in_array($key, $users->entityDataColumns)) {
            die(@json_encode(['success' => false, 'message' => "Unrecognized column {$key} in request", 'data' => []]));
        }
    }
    $filterArgs = [
        'update_user' => ['filter' => FILTER_SANITIZE_STRING, 'flags' => FILTER_FORCE_ARRAY],
        'user_id' => FILTER_VALIDATE_INT
    ];
    $data = filter_var_array($_POST, $filterArgs);
    $users->insert($data);
    if ($users->lastInsertId()) {
        die(@json_encode(['success' => true, 'message' => '', 'data' => []]));
    }
    die(@json_encode(['success' => false, 'message' => 'Could not insert new user', 'data' => [$users->retrieveError()]]));
}
