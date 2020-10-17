<?php
require_once '../../includes/init.php';
global $users;

use Gallery\Utils;

header("Access-Control-Allow-Origin: *");

if ($_POST['password'] !== $_POST['confirm_password']) {
    Utils::sendFinalResponseAsJson(false, 'Passwords do not match', []);
}

foreach ($_POST as $key => $value) {
    if ($key === 'create_new' || $key === 'confirm_password') {
        continue;
    }
    if (!in_array($key, $users->entityDataColumns)) {
        Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
    }
}

if (!empty($_FILES)) {
    $fileUpload = Utils::uploadAndMoveFile($_FILES['image'], true);
}
if (isset($fileUpload) && !$fileUpload) {
    Utils::sendFinalResponseAsJson(false, 'Error uploading file', ['errors' => $users->retrieveError()]);
}

if ($_POST['password'] !== $_POST['confirm_password']) {
    Utils::sendFinalResponseAsJson(false, 'Passwords do not match', []);
}

$alreadyExists = $users->findByUsername($_POST['username']);
if ($alreadyExists) {
    Utils::sendFinalResponseAsJson(false, 'User already exists', []);
}

$users->purifyPostObject();
$users->save();

Utils::sendFinalResponseAsJson(true, '', []);

