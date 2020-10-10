<?php
require_once '../../includes/init.php';
global $users, $session;

use Gallery\Utils;

if (!$session->isSignedIn()) {
    $session->logout();
    Utils::redirect('/admin/login.php');
}

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
if ($alreadyExists['id']) {
    Utils::sendFinalResponseAsJson(false, 'User already exists', []);
}
unset($_POST['confirm_password']);
unset($_POST['create_new']);

$users->validateRequestObject();
$users->insert($_POST);

Utils::sendFinalResponseAsJson(true, '', []);

