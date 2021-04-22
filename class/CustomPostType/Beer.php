<?php 

namespace BeNouze\CustomPostType;
use BeNouze\CustomPostType;

class Beer extends CustomPostType{

    protected $options = [
        'label' => 'Custom post type',

        // optionnel ; aller voir la doc pour avoir des exemple d'utilisation
        //'labels' => [],

        'description' => 'Custom post type',

        'menu_position' => 4,
        'menu_icon' => 'dashicons-location-alt',

        // est ce que les contenus gèrent le fait qu'ils ont un parent
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

        // cet index permet de gérer les droits (acl)
        // lorsque la valeur vaut post ; le "cpt" utilisera les même droits que ceux appliqués sur la gestion des "posts"
        'capability_type' => 'post',

        // attention active Gutenberg  ! ; il faudra que l'on gère la désactivation de gutenberg manuellement
        'show_in_rest' => true,

        // attention à ne surtout pas oublier cette ligne ; si custom capabilitie + Gutenberg
        // 'map_meta_cap' => true,

        'supports' => [
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'trackbacks',
            'comments',

        ],
    ];
};
