<?php

session_start();

if (!empty($_SESSION['user'])) {
    header('Location: /');
    die;
}

require 'Users.php';
require 'DB.php';


$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = new Users(DB::getInstance());
    $res = $users->create($_POST['login'] ?? '', $_POST['password'] ?? '');

    if ($res['status'] === Users::STATUS_SUCCESS) {
        $_SESSION['user'] = $res['user_id'];
        header('Location: /');
        die;
    }

    $error = $res['message'];
}

require './templates/register.php';