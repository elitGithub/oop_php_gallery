<?php
require_once '../../includes/init.php';
global $users;

use Gallery\Users;
use Gallery\Utils;

$session = new \Gallery\Session();
if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

$userid = intval($_POST['user_id']);

if (!is_int($userid)) {
    Utils::sendFinalResponseAsJson(false, "User ID is not a number!", []);
}

header("Access-Control-Allow-Origin: *");

if (isset($_POST['update_user'])) {
    $users->id = $userid;
    foreach ($_POST as $key => $value) {
        if ($key === 'update_user' || $key === 'user_id') {
            continue;
        }
        if (!in_array($key, $users->entityDataColumns)) {
            Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
        }
    }

    $users->retrieveEntityInfo();
    if (!empty($_FILES)) {
        $fileUpload = Utils::uploadAndMoveFile($_FILES['image'], true);
    }
    if (isset($fileUpload) && !$fileUpload) {
        Utils::sendFinalResponseAsJson(false, 'Error uploading file', ['errors' => $users->retrieveError()]);
    }
    $users->purifyPostObject();

    $users->save();
    if ($users->countAffectedRows() === 1) {
        Utils::sendFinalResponseAsJson(true, '', []);
    }
    Utils::sendFinalResponseAsJson(false, 'Nothing was changed', ['errors' => $users->retrieveError()]);
}

Utils::sendFinalResponseAsJson(false, 'No post data!', ['errors' => $_POST]);