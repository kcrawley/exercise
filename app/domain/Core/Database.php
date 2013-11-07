<?php namespace Core;

use Exception;
use PDO;

class Database {
    protected static $dbInstance = null;
    protected $db = null;

    /**
     * Executes a PDO query and binds parameters if detected. Returns PDO Object.
     *
     * @param $statement
     * @param array $bindings
     * @return mixed
     * @throws \Exception
     */
    public static function query($statement, array $bindings = array())
    {
        if (isset(self::$dbInstance) === false) {
            self::establishConnection();
        }

        $db = self::$dbInstance->db;

        $query = $db->prepare($statement);

        // prepare a prepared statement if bindings are present
        if (count($bindings) > 0) {
            // i'd likely use error checking here, but I mainly use ORMs these days. I just wanted to demonstrate
            // my core knowledge regarding pdo/mysql
            $query->execute($bindings);
        } else {
            $query->execute();
        }

        if ($query) {
            return $query->fetchAll(PDO::FETCH_CLASS);
        } else {
            throw new Exception('Something went terribly wrong. PANIC!');
        }
    }

    /**
     * Method to establish connection to the database using the stored database configuration
     */
    protected static function establishConnection()
    {
        self::$dbInstance = new Database;

        if (isset(self::$dbInstance->db) === false) {
            $dbConfig = Config::get('database.mysql');
            self::$dbInstance->db = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['database']};charset={$dbConfig['charset']}",
                $dbConfig['username'],
                $dbConfig['password']
            );
        }
    }
} 