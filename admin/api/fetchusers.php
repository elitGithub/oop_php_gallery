<?php

require_once '../includes/init.php';
use Gallery\Users;


$users = new Users();

if (isset($_GET['find_all'])) {
    die(@json_encode($users->findAll()));
}

if (isset($_GET['find_one']) && isset($_GET['id'])) {
    die(@json_encode($users->findOne($_GET['id'])));
}
