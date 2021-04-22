<?php

namespace BeNouze\Models;

abstract class CoreModel
{
    // propriété qui va nous permettre de communiquer avec la bdd (un espèce de pdo)
    protected $database;

    abstract public static function delete($id);
    abstract public static function getTableName();

    public function __construct()
    {
        // nous allons avoir besoin d'un composant pour communiquer avec la bdd ; nous utilisons la méthode (statique) getDatabase pour récupérer l'objet wp permettant de travailler sur la bdd

       
        $this->database = static::getDatabase();
    }

    public static function insert($data)
    {

        $database = static::getDatabase();

        // DOC https://developer.wordpress.org/reference/classes/wpdb/insert/
        $database->insert(
            static::getTableName(),
            $data
        );
    }

    public static function getDatabase()
    {

        // cette variable globale nous permet d'accéder au composant BDD de wordpress
        global $wpdb;
        return $wpdb;
    }

    public static function executeCreateTableQuery($sql)
    {
        // nous devons un require à la main de cette bibliothèque afin de pouvoir utiliser la fonction dbDelta
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        // https://developer.wordpress.org/reference/functions/dbdelta/
        dbDelta($sql);
    }

    public static function dropTable()
    {
        $tableName = static::getTableName();
        $sql = "
            DROP TABLE {$tableName}
        ";

        static::execute($sql);
    }

    public static function execute($sql)
    {
        $database = static::getDatabase();
        return $database->query($sql);
    }

}
