<?php

namespace BeNouze\Models;

use WP_Query;

class Beer extends CoreModel
{

    public $ID = null;
    public $post_author = null;
    public $post_date = null;
    public $post_date_gmt = null;
    public $post_content = null;
    public $post_title = null;
    public $post_excerpt = null;
    public $post_status = null;
    public $comment_status = null;
    public $ping_status = null;
    public $post_password = null;
    public $post_name = null;
    public $to_ping = null;
    public $pinged = null;
    public $post_modified = null;
    public $post_modified_gmt = null;
    public $post_content_filtered = null;
    public $post_parent = null;
    public $guid = null;
    public $menu_order = null;
    public $post_type = null;
    public $post_mime_type = null;
    public $comment_count = null;

    public static function getTableName()
    {
        $database = static::getDatabase();
        $tableName = $database->prefix . 'posts';
        return $tableName;
    }

    public static function findAll()
    {
        $tableName = static::getTableName();
        $database = static::getDatabase();

        $sql = "SELECT * FROM {$tableName}";

        //! Pas besoin du prepare car pas de paramètre dans la requête
        //$preparedQuery = $database->prepare($sql, []);
        $results = $database->get_results($sql);

        // ce tableau stocke la liste des objets beers
        $beers = [];
        foreach($results as $result) {
            $beer = new Beer();
            $beer->setId($result->id);
            $beer->setTitle($result->title);
            $beer->setDescription($result->description);
            $beer->setCreatedAt($result->created_at);
            $beer->setUpdatedAt($result->updated_at);
            $beers[] = $beer;
        }

        return $beers;

    }

    public function loadById($id)
    {
        $tableName = static::getTableName();
        $database = static::getDatabase();

        $sql = "
            SELECT * FROM {$tableName}
            WHERE id=%d
        ";

        $preparedQuery = $database->prepare($sql, $id);
        $results = $database->get_results($preparedQuery);

        // on récupère la première ligne de résultats
        $firstResult = array_shift($results);

        // pour chaque colonne du résultat (attention le résultat est forme d'un objet "standart"), nous renseignons la propriété correspondante de notre instance
        foreach($firstResult as $columnName => $value) {
            $this->$columnName = $value;
        }
    }


    public static function update($id, $data)
    {
        $tableName = static::getTableName();
        // DOC https://developer.wordpress.org/reference/classes/wpdb/update/
        $database = static::getDatabase();
        $database->update(
            static::getTableName(),
            $data,
            ['id' => $id]
        );
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
            $sql, [
                // les paramètres de la requête doivent respecter l'ordre d'apparition des %* dans la requête
                $id
            ]
        );
        // execution de la requête
        $database->query($preparedQuery);
    }

    public static function createTable()
    {
        $database = static::getDatabase();


        $charset = $database->get_charset_collate();

        $tableName = static::getTableName();

        $sql = "
            CREATE TABLE IF NOT EXISTS `{$tableName}` (
                `id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT,
                `title` VARCHAR(512) NOT NULL,
                `description` TEXT,
                `created_at` DATETIME NOT NULL,
                `updated_at` DATETIME,
                PRIMARY KEY(`id`)
            ) {$charset};
        ";

        static::executeCreateTableQuery($sql);

    }

     /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Get the value of updated_at
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }

}
