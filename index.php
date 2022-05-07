<?php

session_start();

if (empty($_SESSION['user'])) {
    header('Location: /login.php');
    die();
}

require 'Tasks.php';
require 'DB.php';

$tasks = new Tasks(DB::getInstance());

$error = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $res = $tasks->create($_POST['text'] ?? '', $_SESSION['user']);
    if ($res['status'] === 'error') {
        $error = $res['message'];
    }
}

$tasksList = $tasks->get($_SESSION['user']);

require './templates/index.php';

