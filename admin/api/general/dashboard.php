<?php

require_once '../../includes/init.php';

use Gallery\Utils;
use Gallery\Users;
use Gallery\Photos;
use Gallery\Comments;

if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

$users = new Users();
$photos = new Photos();
$comments = new Comments();
// TODO: page views needs to be done more correctly to reflect actual page views...
$data = [
    'users'    => $users->count(),
    'photos'   => $photos->count(),
    'comments' => $comments->count(),
    'views'    => $session->count,
];

Utils::sendFinalResponseAsJson(true, '', $data);