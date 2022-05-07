<?php

class Users {
    private PDO $db;

    public const STATUS_SUCCESS = 1;
    public const STATUS_ERROR = 2;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(string $login, string $password): array
    {
        $login = htmlspecialchars(trim($login));
        $password = htmlspecialchars(trim($password));

        if (!$login || !$password) {
            return [
                'status' => self::STATUS_ERROR,
                'message' => 'Login and password are required!'
            ];
        }

        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        $userId = $this->getUserId($login, $passwordHashed);
        if ($userId) {
            return [
                'status' => self::STATUS_ERROR,
                'message' => 'User with that login already exist'
            ];
        }

        $sql = "INSERT INTO users (login, password) VALUES (?,?)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $passwordHashed]);

        return [
            'status' => self::STATUS_SUCCESS,
            'user_id' => $this->db->lastInsertId()
        ];
    }

    public function get(string $login, string $password): array
    {
        $login = htmlspecialchars(trim($login));
        $password = htmlspecialchars(trim($password));

        if (!$login || !$password) {
            return [
                'status' => self::STATUS_ERROR,
                'message' => 'Login and password required!'
            ];
        }

        $passwordHashed = password_hash($password, PASSWORD_BCRYPT);

        $id = $this->getUserId($login, $passwordHashed);

        if (!$id) {
            return [
                'status' => self::STATUS_ERROR,
                'message' => 'user not found'
            ];
        }

        return [
            'status' => self::STATUS_SUCCESS,
            'user_id' => $id
        ];
    }

    private function getUserId(string $login, $password): int
    {
        $sql = "SELECT id FROM users WHERE login=? AND password=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login, $password]);

        return $stmt->fetchColumn();
    }
}