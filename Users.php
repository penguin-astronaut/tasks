<?php

class Users {
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function register(string $login, string $password): int
    {
        $login = trim($login);
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (login, password) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $passwordHashed]);

        return $this->db->lastInsertId();
    }

    public function login(string $login, string $password): int
    {
        $login = trim($login);
        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        $sql = "SELECT id FROM users WHERE login=? AND password=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $passwordHashed]);

        return $stmt->fetchColumn();
    }
}