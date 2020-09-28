<?php


namespace Gallery;


class Utils
{
    public static function redirect($location) {
        header("Location: $location");
    }
}