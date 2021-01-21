<?php


namespace Core;


use PDO;
use PDOStatement;

class Database
{
    /**
     * @var PDO
     */
    public static PDO $connection;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        if (!isset(self::$connection)) {
            $dsn = "mysql:host=localhost;dbname=forum";
            self::$connection = new PDO($dsn, 'root', 'root', [
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }
    }

    /**
     * @param mixed ...$params
     *
     * @return PDOStatement
     */
    public function query(... $params): PDOStatement
    {
        $query = array_shift($params);

        $statement = self::$connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }

    /**
     * @return mixed Last insert ID
     */
    public function lastId(): mixed
    {
        return self::$connection->lastInsertId();
    }
}