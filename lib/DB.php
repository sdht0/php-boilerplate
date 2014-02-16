<?php

require_once INCLUDES_DIR . 'ErrorHandler.php';

/**
 * DB - Functions to make database operations clean and safe.
 * @package PHPBoilerplate
 * @author: Siddhartha Sahu <me@siddharthasahu.in>
 */
class DB extends ErrorHandler {

    /**
     * Connection link to MySQL DB
     * @type PDO Instance
     */
    public static $connection = NULL;

    /**
     * Initialize the DB connection
     * @return bool
     */
    public static function initialize() {
        if (self::$connection != NULL)
            return true;
        try {
            self::$connection = new PDO("mysql:dbname=" . SQL_DB . ";host=" . SQL_HOST . ";port=" . SQL_PORT . "", SQL_USER, SQL_PASS, array(
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ));
            self::$connection->exec("SET CHARACTER SET utf8");
        } catch (PDOException $error) {
            self::$connection = NULL;
            self::handleError('DB Connection failed', $error);
            die("Error creating database connection!");
            return false;
        }
        return true;
    }

    /**
     * Close the DB connection
     * @return void
     */
    public static function closeConnection() {
        self::$connection = NULL;
    }

    /**
     * Execute a Query
     * @param string $query The query to execute
     * @param array $values Values to use in case of prepared statements
     * @return mixed
     */
    public static function query($query, $values = NULL) {
        if (!self::initialize())
            return false;
        try {
            if (is_array($values)) {
                $stmt = self::$connection->prepare($query);
                return $stmt->execute($values);
            } else {
                return self::$connection->query($query);
            }
        } catch (PDOException $e) {
            self::handleError($query, $e);
            return false;
        }
    }

    /**
     * Insert single row into a table
     * @param string $table The table where values should be inserted
     * @param array $data Array containing columnName => value pairs
     * @return int
     */
    public static function insert($table, $data) {
        if (!self::initialize())
            return false;
        $keys = array();
        $values = array();
        foreach ($data as $key => $value) {
            $keys[] = $key;
            $values[] = self::$connection->quote($value);
        }
        $query = 'INSERT INTO ' . $table . ' (' . join(', ', $keys) . ') VALUES (' . join(', ', $values) . ')';
        try {
            return self::$connection->exec($query);
        } catch (PDOException $e) {
            self::handleError($query, $e);
            return false;
        }
    }

    public static function lastInsertId() {
        if (!self::initialize())
            return false;
        return self::$connection->lastInsertId();
    }

    /**
     * Update rows in a table
     * @param string $table The table where values should be inserted
     * @param array $data Array containing columnName => value pairs
     * @param string $where SQL condition for the update
     * @param array $values Values to use in case of prepared statements
     * @return mixed
     */
    public static function update($table, $data, $where, $values = NULL) {
        if (!self::initialize())
            return false;
        $setters = array();
        foreach ($data as $key => $value) {
            $setters[] = $key . '=' . self::$connection->quote($value);
        }
        $query = 'UPDATE ' . $table . ' SET ' . join(', ', $setters) . ' WHERE ' . $where;
        try {
            if (is_array($values)) {
                $stmt = self::$connection->prepare($query);
                $stmt->execute($values);
            } else {
                $stmt = self::$connection->exec($query);
            }
            return $stmt;
        } catch (PDOException $e) {
            self::handleError($query, $e);
            return false;
        }
    }

    /**
     * Delet rows from a table
     * @param string $table The table where values should be inserted
     * @param string $where SQL condition for the delete operation
     * @param array $values Values to use in case of prepared statements
     * @return mixed
     */
    public static function delete($table, $where, $values = NULL) {
        return self::query("delete from $table where " . $where, $values);
    }

    /**
     * Execute a Query and return all results in 2D-array form
     * @param string $query The query to execute
     * @param array $values Values to use in case of prepared statements
     * @param PDOConstant $fetchType Type of array to return. Refer to PDO documentation for more information
     * @return array
     */
    public static function findAllFromQuery($query, $values = NULL, $fetchType = PDO::FETCH_ASSOC) {
        if (!self::initialize())
            return false;
        try {
            if (is_array($values)) {
                $stmt = self::$connection->prepare($query);
                $stmt->execute($values);
            } else {
                $stmt = self::$connection->query($query);
            }
            return $stmt->fetchAll($fetchType);
        } catch (PDOException $e) {
            self::handleError($query, $e);
            return false;
        }
    }

    /**
     * Execute a Query and return a single result in 1D-array form
     * @param string $query The query to execute
     * @param array $values Values to use in case of prepared statements
     * @param PDOConstant $fetchType Type of array to return. Refer to PDO documentation for more information
     * @return array
     */
    public static function findOneFromQuery($query, $values = NULL, $fetchType = PDO::FETCH_ASSOC) {
        if (!self::initialize())
            return false;
        try {
            if (is_array($values)) {
                $stmt = self::$connection->prepare($query);
                $stmt->execute($values);
            } else {
                $stmt = self::$connection->query($query);
            }
            return $stmt->fetch($fetchType);
        } catch (PDOException $e) {
            self::handleError($query, $e);
            return false;
        }
    }

    /**
     * Quotes given string to make it safe for database queries
     * @param string $value The string to quote
     * @return string The quotes string
     */
    public static function quote($value) {
        if (!self::initialize())
            return false;
        return self::$connection->quote($value);
    }

}
