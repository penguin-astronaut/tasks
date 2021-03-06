<?php

class Users {
    private PDO $db;

    public const STATUS_USER_NOT_FOUND = 1;
    public const STATUS_ERROR_PASSWORD = 2;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function checkUser(string $login, string $password): array
    {
        $login = htmlspecialchars(trim($login));
        $password = htmlspecialchars(trim($password));

        if (!$login || !$password) {
            return [
                'status' => 'error',
                'message' => 'Login and password are required!'
            ];
        }
        $sql = "SELECT * FROM users WHERE login=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login]);

        if (!$user = $stmt->fetch()) {
            return [
                'status' => 'error',
                'code' => self::STATUS_USER_NOT_FOUND
            ];
        }

        if (!password_verify($password, $user['password'])) {
            return [
                'status' => 'error',
                'code' => self::STATUS_ERROR_PASSWORD
            ];
        }

        return [
            'status' => 'success',
            'user_id' => $user['id']
        ];
    }

    public function create(string $login, string $password): array
    {
        $login = htmlspecialchars(trim($login));
        $password = htmlspecialchars(trim($password));

        if (!$login || !$password) {
            return [
                'status' => 'error',
                'message' => 'Login and password are required!'
            ];
        }

        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);


        $sql = "INSERT INTO users (login, password) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $passwordHashed]);

        return [
            'status' => 'success',
            'user_id' => $this->db->lastInsertId()
        ];
    }
}