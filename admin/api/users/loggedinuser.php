<?php

require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Utils;

$session = new \Gallery\Session();
if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

global $users;
$session = new Session();
Utils::sendFinalResponseAsJson(true, '', $users->findOne($session->getLoggedInUser()));