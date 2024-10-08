<?php
/**
 * Database Connection Class
 *
 *Establish connection  with the MySQL database
 *
 * Filename:        Connection.php
 * Location:        includes
 * Project:         LAS-PHP-MVC-Jokes
 * Date Created:    13/08/2024
 *
 * Author:          Luis Alvarez Suarez <20114831@tafe.wa.edu.au>
 *
 */

require_once __DIR__.'/../config.php';

class Connection
{
    public static function make($host, $db, $username, $password)
    {
        $dsn = "mysql:host=$host;dbname=$db;charset=UTF8";

        try {
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

            return new PDO($dsn, $username, $password, $options);
        } catch (PDOException $e) {
            die($e->getMessage());
        }

    }
}

return Connection::make($dbHost, $dbName, $dbUser, $dbPass);

