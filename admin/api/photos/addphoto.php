<?php

require_once '../../includes/init.php';
use Gallery\Utils;
global $users, $photos;



if (!$session->isSignedIn()) {
    Utils::sendFinalResponseAsJson(false, 'You are not signed in', []);
}

header('Content-Type: application/json');

$success = $photos->uploadFile($_FILES['image']);

$message = $success ? '' : 'Failed to upload file';

Utils::sendFinalResponseAsJson($success, $message, $photos->customErrors ?? []);