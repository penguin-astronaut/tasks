<?php

session_start();

require './models/Tasks.php';
require './db/DB.php';

$tasks = new Tasks(DB::getInstance());

$action = $_GET['action'];

switch ($action) {
    case 'remove':
        if (isset($_GET['id'])) {
            $tasks->remove($_GET['id'], $_SESSION['user']);
        }
        break;
    case 'remove_all':
        $tasks->removeAll($_SESSION['user']);
        break;
    case 'change_status':
        if (isset($_GET['status'])) {
            $status = $_GET['status'] === 'ready' ? Tasks::STATUS_READY : Tasks::STATUS_UNREADY;
            $tasks->changeStatus($_GET['id'], $_SESSION['user'],$status);
        }
        break;
    case 'ready_all':
        $tasks->readyAll($_SESSION['user']);
        break;
}

header('Location: /');