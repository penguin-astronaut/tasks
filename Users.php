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

        $userId = $this->checkLogin($login);
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

        $id = $this->getUserId($login, $password);

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

    private function getUserId(string $login, string $password): int
    {
        $sql = "SELECT * FROM users WHERE login=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login]);
        if (!$user = $stmt->fetch()) {
            return 0;
        }

        if (!password_verify($password, $user['password'])) {
            return 0;
        }

        return $user['id'];
    }

    private function checkLogin(string $login): int
    {
        $sql = "SELECT id FROM users WHERE login=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$login]);

        return $stmt->fetchColumn();
    }
}