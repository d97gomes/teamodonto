<?php

class Database {

    private static $conn = null;

    public static function connect() {

        if (self::$conn === null) {
            try {
                self::$conn = new PDO(
                    "mysql:host=localhost;port=3306;dbname=teamodonto;charset=utf8mb4",
                    "hadoopInsano",
                    "Springlocao",
                    [
                        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES   => false
                    ]
                );
            } catch (PDOException $e) {
                die('Erro de conexão com o banco de dados.');
            }
        }

        return self::$conn;
    }
}