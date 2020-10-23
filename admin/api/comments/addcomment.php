<?php

require_once '../../includes/init.php';

use Gallery\Comments;
use Gallery\Utils;


$comments = new Comments();
foreach ($_POST as $key => $value) {
    if (!in_array($key, $comments->entityDataColumns)) {
        Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
    }
}

$comments->save();


