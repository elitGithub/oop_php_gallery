<?php

function classAutoloader($class) {
    require_once "classes/{$class}.php";
}

spl_autoload_register('classAutoloader');

