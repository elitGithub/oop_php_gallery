<?php

require_once '../../includes/init.php';

use Gallery\Comments;
use Gallery\Utils;
global $users;

$comments = new Comments();
header('Content-Type: application/json');

Utils::sendFinalResponseAsJson(true, '', $comments->findAll());