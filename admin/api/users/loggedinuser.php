<?php

require_once '../../includes/init.php';

use Gallery\Utils;


if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

global $users;

Utils::sendFinalResponseAsJson(true, '', $users->findOne($session->getLoggedInUser()));