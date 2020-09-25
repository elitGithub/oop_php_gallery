<?php
require_once '../includes/init.php';
use Gallery\Users;
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo "Hello monkey".PHP_EOL;
print_r($_POST);
$users = new Users();

die;
if (isset($_POST['update_user'])) {
    $post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    die(@json_encode(['success' => $users->updateOne($post['user_id'], $post['form_data'])]));
}