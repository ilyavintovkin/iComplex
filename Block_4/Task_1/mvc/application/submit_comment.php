<?php
// Подключение к базе данных
$host = 'mysql_mvc';
$db   = 'mydatabase';
$user = 'root';
$pass = 'rootpassword';
$charset = 'utf8mb4';

// Создание DSN для PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    // Проверка, что форма была отправлена
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Получаем данные из формы
        $author = htmlspecialchars($_POST['author']);
        $message = htmlspecialchars($_POST['message']);

        // Подготовка SQL-запроса для вставки данных
        $sql = "INSERT INTO comments (author, message) VALUES (:author, :message)";
        $stmt = $pdo->prepare($sql);

        // Выполнение запроса
        $stmt->execute(['author' => $author, 'message' => $message]);

        // Перенаправление на главную страницу через 2 секунды
        header("Location: /comment");  // Редирект на нужную страницу

        exit; // завершение скрипта, чтобы не было дальнейших выводов
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage();
}

