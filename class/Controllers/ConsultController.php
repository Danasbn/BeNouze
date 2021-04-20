<?php

namespace BeNouze\Controllers;

use BeNouze\Models\Consult;
use WP_Query;

class ConsultController extends CoreController
{
    public $id = null;
    public $beer = null;
    public $user_id = null;
    public $created_at = null;
    public $updated_at = null;

    public static function createTable()
    {
        $database = static::getDatabase();

        // récupèration du charset (alphabet) utilisé par la bdd sur laquelle tourne wp
        // $database->prefix nous permet de récupérer le préfixe des tables wp
        $charset = $database->get_charset_collate();

        $tableName = static::getTableName();

        $sql = "
                CREATE TABLE IF NOT EXISTS `{$tableName}` (
                `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                `beer_id` DECIMAL NOT NULL,
                `user_id` INT(8) UNSIGNED NOT NULL,
                `date` INT(8),              
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME,
                PRIMARY KEY(`id`)
                ) {$charset};
                ";

        static::executeCreateTableQuery($sql);
    }

    public static function getTableName()
    {
        $tableName = 'benouze_consulted_beers';
        return $tableName;
    }
   
}