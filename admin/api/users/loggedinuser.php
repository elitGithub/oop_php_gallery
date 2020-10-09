<?php

require_once '../../includes/init.php';

use Gallery\Utils;

global $users, $session;

Utils::sendFinalResponseAsJson(true, '', $users->findOne($session->getLoggedInUser()));