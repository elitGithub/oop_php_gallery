<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;

$session = new \Gallery\Session();

if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Utils::sendFinalResponseAsJson(true, '', $photos->findOne($id));
}

Utils::sendFinalResponseAsJson(true, '', $photos->findAll());
