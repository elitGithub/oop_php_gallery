<?php

require_once '../includes/init.php';
use Gallery\Users;


$users = new Users();
if (true || isset($_POST['create_user'])) {
    $data = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $users->insert($data);
    if ($users->lastInsertId()) {
        die(@json_encode(['success' => true, 'message' => '', 'data' => []]));
    }
    die(@json_encode(['success' => false, 'message' => 'Could not insert new user', 'data' => [$users->retrieveError()]]));
}
