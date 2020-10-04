<?php

require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Users;
use Gallery\Utils;



Utils::sendFinalResponseAsJson(true, '', $users->findOne($session->getLoggedInUser()));