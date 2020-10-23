<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;

$session = new \Gallery\Session();
if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

$id = intval($_POST['photo_id']);

$photos->id = $id;
$photos->retrieveEntityInfo();
foreach ($_POST as $key => $item) {
    $photos->columnFields[$key] = $item;
}
$photos->save();

Utils::sendFinalResponseAsJson(true, '', []);