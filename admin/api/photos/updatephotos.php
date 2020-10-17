<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;

header('Content-Type: application/json');

$id = intval($_POST['photo_id']);

$photos->id = $id;
$photos->retrieveEntityInfo();
foreach ($_POST as $key => $item) {
    $photos->columnFields[$key] = $item;
}
$photos->save();

Utils::sendFinalResponseAsJson(true, '', []);