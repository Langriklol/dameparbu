<?php

/**
 * Created by PhpStorm.
 * User: Ondřej
 * Date: 27.06.2016
 * Time: 15:45
 */
class Db
{
    private static $connection;

    /** Db Settings */
    private static $settings = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
        PDO::ATTR_EMULATE_PREPARES => false,
    );
    /** Connect to database */
    public static function connect($host, $user, $passwd, $database) {
        if (!isset(self::$connection)) {
            self::$connection = @new PDO(
                "mysql:host=$host;dbname=$database",
                $user,
                $passwd,
                self::$settings
            );
        }
    }

    /** Return first searched item from query in table */
    public static function queryOnce($query, $params = array()) {
        $return = self::$connection->prepare($query);
        $return->execute($params);
        return $return->fetch();
    }
    /** return all searched items from query in table */
    public static function queryAll($query, $params = array()) {
        $return = self::$connections->prepare($query);
        $return->execute($params);
        return $return->fetchAll();
    }
    /** Return one col from query in table */
    public static function querySelf($query, $params = array()) {
        $result = self::queryOnce($query, $params);
        return $result[0];
    }
    /** Return count of changed rows */
    public static function query($query, $params = array()) {
        $return = self::$connection->prepare($query);
        $return->execute($params);
        return $return->rowCount();
    }
    /** Inserts data into table */
    public static function insert($table, $params = array()) {
        return self::query("INSERT INTO `$table` (`".
            implode('`, `', array_keys($params)).
            "`) VALUES (".str_repeat('?,', sizeOf($params)-1)."?)",
            array_values($params));
    }
    /** change data in table */
    public static function change($table, $values = array(), $if, $params = array()) {
        return self::query("UPDATE `$table` SET `".
            implode('` = ?, `', array_keys($values)).
            "` = ? " . $if,
            array_merge(array_values($values), $params));
    }
    /** get last ID of inserted */
    public static function getLastId()
    {
        return self::$spojeni->lastInsertId();
    }
}