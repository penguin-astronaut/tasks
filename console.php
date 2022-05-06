<?php

require './Migration.php';

$host = '127.0.0.1';
$db   = 'tasks';
$user = 'root';
$pass = '';
$charset = 'utf8';

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$pdo = new PDO($dsn, $user, $pass, $opt);
$migration = new Migration($pdo);
$migration->migrate();