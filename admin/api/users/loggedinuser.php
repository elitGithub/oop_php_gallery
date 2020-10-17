<?php

require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Utils;

global $users;
$session = new Session();
Utils::sendFinalResponseAsJson(true, '', $users->findOne($session->getLoggedInUser()));