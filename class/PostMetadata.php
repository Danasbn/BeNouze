<?php

namespace BeNouze;


class PostMetadata
{
    protected $name;
    protected $label;
    protected $customPostType;

    public function __construct($customPostType, $name, $label)
    {
        $this->customPostType = $customPostType;
        $this->name = $name;
        $this->label = $label;
    }

    public function register()
    {
        add_action('edit_form_after_editor', [$this, 'editForm']);

        // on enregistre l'appel à la méthode save sur un event qui a la forme suivante :
        // save_post_CUSTOM_POST_NAME
        add_action('save_post_' . $this->customPostType, [$this, 'save']);
    }

    public function editForm($post)
    {

        if($post->post_type !== $this->customPostType) {
            return false;
        }

        $values = get_post_meta(
            $post->ID,
            $this->name,
        );

        if(!empty($values)) {
            // attention wp renvoie un tableau lorsque l'on accède à la valeur d'une métadata
            $value = $values[0];
        }
        else {
            $value = '';
        }
        
         echo '
          
             <div class="form-field">
                 <label for="' . $this->name . '">' . $this->label . '</label>
                 <input type="text" name="' . $this->name . '" id="' . $this->name . '" value="' . $value . '"/>
             </div>
         ';
    }

    public function save($postId)
    {
        // récupération de la valeur envoyée dans le formulaire
        $value = filter_input(INPUT_POST, $this->name);

        // enregistrement de la valeur en BDD
        // DOC https://developer.wordpress.org/reference/functions/update_post_meta/
        update_post_meta(
            $postId,
            $this->name,
            $value
        );
    }
}
