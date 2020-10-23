<?php
require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;


if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (empty($id) || !is_int($id)) {
        Utils::sendFinalResponseAsJson(false, 'Photo Id is missing!', []);
    }
    $photos->deleteOne($id);
    Utils::sendFinalResponseAsJson(true, '', []);
}