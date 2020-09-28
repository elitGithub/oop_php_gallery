<?php

require_once '../../includes/init.php';

use Gallery\Session;

$session = new Session();
$session->logout();