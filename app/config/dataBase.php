<?php

class Database {

    public static function conectar(): PDO {
        return new PDO(
            "mysql:host=localhost;port=3306;dbname=teamodonto;charset=utf8",
            "hadoopInsano",        // ou outro usuário do seu MySQL
            "Springlocao",            // senha do seu MySQL
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }
}