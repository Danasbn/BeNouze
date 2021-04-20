<?php

namespace BeNouze\Models;

use WP_Query;

class Consult extends CoreModel
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
    public function save()
    {

        $beer = get_the_ID();
        $user = get_current_user_id();
        $date = date('Y-m-d H:i:s');

        Consult::insert([
            'beer_id' => $beer,
            'date' => $date,
            'user_id' => $user,
        ]);
    }
    public static function getTableName()
    {
        $tableName = 'benouze_consulted_beers';
        return $tableName;
    }
    public static function delete($id)
    {
        $tableName = static::getTableName();

        // DOC https://www.php.net/sprintf
        $sql = "
            DELETE FROM `{$tableName}`
            WHERE `id`=%d
        ";

        // récupération de l'obget global $wpdb
        $database = static::getDatabase();

        // préparation de la requête ; il faut passer les valeurs à injecter dans la requête
        $preparedQuery = $database->prepare(
            $sql,
            [
                // les paramètres de la requête doivent respecter l'ordre d'apparition des %* dans la requête
                $id
            ]
        );
        // execution de la requête
        $database->query($preparedQuery);
    }
}
