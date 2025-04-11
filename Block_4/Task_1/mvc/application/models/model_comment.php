<?php

class Model_Comment extends Model
{
    public function getAll(): array
    {
        $host = 'mysql_mvc'; // имя контейнера MySQL из docker-compose
        $db   = 'mydatabase';
        $user = 'root';
        $pass = 'rootpassword';
        $charset = 'utf8';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $pdo = new PDO($dsn, $user, $pass, $options);

            $stmt = $pdo->query("SELECT * FROM comments");
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            echo "Ошибка подключения к БД: " . $e->getMessage();
            return [];
        }
    }
}