<?php

class DBConnection {
    private static string $dbHost = "localhost";
    private static string $dbName = "WW1";
    private static string $dbUser = "root";
    private static string $dbPass = "";
    private static ?PDO $connection = null;

    public static function getConnection(): ?PDO {
        if (self::$connection === null) {
            try {
                self::$connection = new PDO(
                    "mysql:host=" . self::$dbHost . ";dbname=" . self::$dbName . ";charset=utf8",
                    self::$dbUser,
                    self::$dbPass
                );
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}

?>
