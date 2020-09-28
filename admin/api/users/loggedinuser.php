<?php

require_once '../../includes/init.php';

use Gallery\Session;
use Gallery\Users;


$users = new Users();
$session = new Session();
die(@json_encode(['success' => true, 'message' => '', 'data' => $users->findOne($session->getLoggedInUser())]));