<?php
require_once '../../includes/init.php';
use Gallery\Users;
use Gallery\Utils;
$userid = intval($_POST['user_id']);

if (!is_int($userid)) {
    Utils::sendFinalResponseAsJson(false, "User ID is not a number!", []);
}

header("Access-Control-Allow-Origin: *");

if (isset($_POST['update_user'])) {
    unset($_POST['update_user']);
    unset($_POST['user_id']);
    foreach ($_POST as $key => $value) {
        if (!in_array($key, $users->entityDataColumns)) {
            Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
        }
    }

    $user = $users->findOne($userid);
    if (!empty($_FILES)) {
        $fileUpload = Utils::uploadAndMoveFile($_FILES['image'], true);
    }
    if (isset($fileUpload) && !$fileUpload) {
        Utils::sendFinalResponseAsJson(false, 'Error uploading file', ['errors' => $users->retrieveError()]);
    }

    $diff = array_diff($user, $_POST);
    $diff = array_diff(array_keys($diff), Users::EXCLUDED_FIELDS);
    if (sizeof($diff) > 0) {
        $users->updateOne($userid, $_POST);
        if ($users->countAffectedRows() === 1) {
            Utils::sendFinalResponseAsJson(true, '', []);
        }
    }
    Utils::sendFinalResponseAsJson(false, 'Nothing was changed', ['errors' => $users->retrieveError()]);
}

Utils::sendFinalResponseAsJson(false, 'No post data!', ['errors' => $_POST]);