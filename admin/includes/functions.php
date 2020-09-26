<?php

function classAutoloader($class) {
    require_once "classes/{$class}.inc.php";
}

spl_autoload_register('classAutoloader');