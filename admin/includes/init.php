<?php

use Gallery\Session;
use Gallery\Users;

error_reporting(0);

require_once 'functions.php';
require_once 'config.inc.php';
require_once 'classes/Gallery/Database.php';
require_once 'classes/Gallery/Utils.php';
require_once 'classes/Gallery/Session.php';
require_once 'classes/Gallery/Users.php';

$users = new Users();
$session = new Session();