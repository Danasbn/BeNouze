<?php

namespace BeNouze;

class CustomRole
{

    protected $name;
    protected $label;

    protected $capabilities = [
        //'publish_posts' => true,
        //'edit_posts' => true,
        //'delete_posts' => true,
        //'edit_published_posts' => true,
        //'delete_published_posts' => true,
        //'upload_files' => true,
        'read' => true,
    ];


    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function register()
    {
        add_role(
            $this->name,
            $this->label,
            $this->capabilities
        );
    }

    public function delete()
    {
        //DOC https://developer.wordpress.org/reference/functions/remove_role/
        remove_role($this->name);
    }
}