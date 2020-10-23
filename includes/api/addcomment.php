<?php

require_once '../../admin/includes/functions.php';
require_once '../../admin/includes/config.inc.php';
require_once '../../admin/includes/classes/Gallery/Utils.php';

use Gallery\Comments;
use Gallery\Utils;

$comments = new Comments();
$comments->retrieveEntityInfo();

foreach ($_POST as $key => $value) {
    if (!in_array($key, $comments->entityDataColumns)) {
        Utils::sendFinalResponseAsJson(false, "Unrecognized column {$key} in request", []);
    }
    $comments->columnFields[$key] = $value;
}

$comments->save();

if ($comments->lastInsertId()) {
    Utils::sendFinalResponseAsJson(true, '', []);
}
