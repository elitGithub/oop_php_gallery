<?php

require_once '../../includes/init.php';

use Gallery\Utils;
use Gallery\Session;
use Gallery\Users;
use Gallery\Photos;
use Gallery\Comments;

$session = new Session();

if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

$users = new Users();
$photos = new Photos();
$comments = new Comments();

$data = [
    'users' => $users->count(),
    'photos' => $photos->count(),
    'comments' => $comments->count(),
];

Utils::sendFinalResponseAsJson(true, '', $data);