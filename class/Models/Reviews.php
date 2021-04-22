<?php

namespace BeNouze\Models;

use WP_Query;

class Reviews extends CoreModel{

    public $id = null;
    public $note = null;
    public $user_id = null;
    public $term_id = null;
    public $post_id = null;
    public $created_at = null;
    public $updated_at = null;



    public static function createTable()
    {
        $database = static::getDatabase();
        
        $charset = $database->get_charset_collate();

        $tableName = static::getTableName();
       
        $sql = "
            CREATE TABLE IF NOT EXISTS `{$tableName}` (
                `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                `note` DECIMAL NOT NULL, 
                `user_id` INT(8) UNSIGNED NOT NULL,
                `term_id` INT(8),
                `beer_id` INT(8) UNSIGNED NOT NULL,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME,
                PRIMARY KEY(`id`)
            ) {$charset};
        ";

        static::executeCreateTableQuery($sql);
    }

    public static function getTableName()
    {
        $tableName = 'benouze_reviews'; 
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

        $database = static::getDatabase();

        $preparedQuery = $database->prepare(
            $sql,
            [
                $id
            ]
        );
        $database->query($preparedQuery);
    }

    public static function update($id, $data)
    {
        $tableName = static::getTableName();

        $database = static::getDatabase();
        $database->update(
            static::getTableName(),
            $data,
            ['id' => $id]
        );
    }

}
