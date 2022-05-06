<?php

class DB {
    private static PDO $instance;

    private function __construct()
    {}

    public static function getInstance(): PDO
    {
        if (empty(self::$instance)) {
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

            self::$instance = new PDO($dsn, $user, $pass, $opt);
        }

        return self::$instance;
    }
}