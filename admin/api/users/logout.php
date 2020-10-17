<?php

use Gallery\Session;

require_once '../../includes/init.php';
$session = new Session();
$session->logout();