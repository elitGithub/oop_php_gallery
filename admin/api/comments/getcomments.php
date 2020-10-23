<?php

require_once '../../includes/init.php';

use Gallery\Comments;
use Gallery\Session;
use Gallery\Utils;
global $users;

$session = new Session();

if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}
$comments = new Comments();
header('Content-Type: application/json');

if (isset($_GET['find_one'])) {
    $id = intval($_GET['id']);
    if (!is_int($id)) {
        Utils::sendFinalResponseAsJson(false, 'ID is not a number!', []);
    }
    Utils::sendFinalResponseAsJson(true, '', $comments->findOne($id));
}

$data = [
    'comments' => $comments->getAllComments(),
    'count' => $comments->count(),
];

Utils::sendFinalResponseAsJson(true, '', $data);