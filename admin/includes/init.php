<?php

use Gallery\Photos;
use Gallery\Session;
use Gallery\Users;

require_once 'functions.php';
require_once 'config.inc.php';
require_once 'classes/Gallery/Database.php';
require_once 'classes/Gallery/Utils.php';
require_once 'classes/Gallery/Session.php';
require_once 'classes/Gallery/Users.php';
require_once 'classes/Gallery/Photos.php';
require_once 'classes/Gallery/Comments.php';
require_once 'classes/Gallery/Paginate.php';

$users = new Users();
$photos = new Photos();
$session = new Session();