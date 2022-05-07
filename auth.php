<?php

session_start();

if (!empty($_SESSION['user'])) {
    header('Location: /');
    die;
}

require './models/Users.php';
require './db/DB.php';


$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $users = new Users(DB::getInstance());
    $res = $users->checkUser($_POST['login'] ?? '', $_POST['password'] ?? '');

    if ($res['status'] === 'success') {
        $_SESSION['user'] = $res['user_id'];
        header('Location: /');
        die;
    } elseif ($res['code'] === Users::STATUS_USER_NOT_FOUND) {
        $res = $users->create($_POST['login'] ?? '', $_POST['password'] ?? '');

        if ($res['status'] === 'success') {
            $_SESSION['user'] = $res['user_id'];
            header('Location: /');
            die;
        }

        $error = $res['message'];
    } elseif ($res['code'] === Users::STATUS_ERROR_PASSWORD) {
        $error = 'password incorrect';
    }
}

require './templates/auth.php';