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

$id = intval($_GET['id']);

$comments = new Comments();

$comments->deleteOne($id);

Utils::sendFinalResponseAsJson(true, '', []);