<?php

require_once '../../includes/init.php';
use Gallery\Users;
use Gallery\Utils;


$users = new Users();

if (isset($_GET['find_all'])) {
    Utils::sendFinalResponseAsJson(true, '', $users->findAll());
}

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    Utils::sendFinalResponseAsJson(true, '', $users->findOne($_GET['id']));
}
