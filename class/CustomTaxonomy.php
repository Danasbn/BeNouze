<?php

namespace BeNouze;


class CustomTaxonomy
{

    protected $name;
    protected $label;

    // liste des postTypes sur lesquel  la taxonomie est applicable
    protected $postTypes = [];

    // $isHierarchical ; true : assimilable à une catégorie ; false : assimilable à un tag
    protected $isHierarchical = true;

    public function __construct($name, $label, array $postTypes)
    {
        $this->postTypes = $postTypes;
        $this->name = $name;
        $this->label = $label;
    }


    public function register()
    {
        add_action('init', [$this, 'registerTaxonomy']);
    }


    public function registerTaxonomy()
    {
        // DOC https://developer.wordpress.org/reference/functions/register_taxonomy/
        register_taxonomy(
            $this->name,
            $this->postTypes,
            [
                'hierarchical' => $this->isHierarchical,
                'label' => $this->label,
                'show_ui' => true,
                'show_in_rest' => true,
                'show_admin_column' => true,
                'query_var' => true,
                'embeddable' => true,
                'rewrite' => [
                    'slug' => $this->name
                ],
            ]
        );
    }
}
