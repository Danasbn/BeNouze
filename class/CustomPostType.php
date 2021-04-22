<?php

namespace BeNouze;

class CustomPostType {
    protected $name;
    protected $label;
    protected $options = [
        'label' => 'Custom post type',
        'description' => 'Custom post type',
        'menu_position' => 4,
        'menu_icon' => 'dashicons-beer',
        'hierarchical' => false,
        // le custom post type sera éditable depuis le bo
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
        'supports' => [
            'title',
            'editor',
             'excerpt',
            'thumbnail',
             'comments',
        ],
    ];
    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function register()
    {
        // création du post type
        add_action('init', [$this, 'registerPostType']);

        // désactivation de gutenberg
        // 10 représente la priorité de la fonction; 10 souvent valeur par défaut
        // 2 représente le nombre de paramètre que wordpress va récupéré
        add_filter('use_block_editor_for_post_type', [$this, 'disableGutemberg'], 10, 2);

        // on donne à l'administateur les droits sur le custom post type
       // add_action('admin_init', [$this, 'addCapabilitiesToAdmin']);
    }


    public function registerPostType()
    {
        // register_post_type est une méthode "native de wordpress
        // https://developer.wordpress.org/reference/functions/register_post_type/
        register_post_type($this->name, $this->getOptions());
    }
    public function getOptions()
    {
        $arguments = $this->options;
        $arguments['label'] = $this->label;

        // force le route pour l'api rest
        // $arguments['rewrite']['slug'] = $this->name;


        $arguments['capability_type'] =  $this->name;

        return $arguments;
    }
    public function disableGutemberg($isGutenbergEnable, $postType)
    {
        if ($postType === $this->name) {
            return false;
        } else {
            return $isGutenbergEnable;
        }
    }
}
