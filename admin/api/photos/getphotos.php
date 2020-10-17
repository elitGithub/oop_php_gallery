<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;

header('Content-Type: application/json');

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    Utils::sendFinalResponseAsJson(true, '', $photos->findOne($id));
}

Utils::sendFinalResponseAsJson(true, '', $photos->findAll());
