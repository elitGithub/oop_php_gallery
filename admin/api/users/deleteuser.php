<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $session;

header('Content-Type: application/json');

if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if (empty($id) || !is_int($id)) {
        Utils::sendFinalResponseAsJson(false, 'User Id is missing!', []);
    }
    $users->deleteOne($id);
    Utils::sendFinalResponseAsJson(true, '', []);
}