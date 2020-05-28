<?php

class DB
{
    /**
     * Database information.
     * @var string
     */
    private static $hostname = "localhost";
    private static $dbname = 'site';
    private static $username = 'pumba';
    private static $password = "Romain181079";
    // Static db instance.
    private static $db = null;

    /**
     * Create / return the database instance ( Singleton pattern ).
     * @return MySqli|null
     */
    public static function getDbLink()
    {
        if(is_null(self::$db)) {
            self::$db = new MySqli(self::$hostname, self::$username, self::$password, self::$dbname);
            if(self::$db->connect_errno)
                die('Erreur de connexion à la database !');
        }
        return self::$db;
    }
}