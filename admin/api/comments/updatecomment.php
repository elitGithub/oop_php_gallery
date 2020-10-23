<?php

require_once '../../includes/init.php';

use Gallery\Comments;
use Gallery\Utils;
global $users;


if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

$id = intval($_POST['id']);

$comments = new Comments();
$comments->id = $id;
$comments->retrieveEntityInfo();
foreach ($_POST as $key => $item) {
    $comments->columnFields[$key] = $item;
}
$comments->save();

Utils::sendFinalResponseAsJson(true, '', []);