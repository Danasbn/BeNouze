<?php

namespace BeNouze\PostMetadata;

use BeNouze\PostMetadata;

class BeerReviews extends PostMetadata
{
    public function editForm($post)
    {
        // le champ BeerReviews ne s'affiche que si l'on est admin
        $user = wp_get_current_user();
        $roles = $user->roles;

        if (!in_array('administrator', $roles)) {
            return false;
        }

        if ($post->post_type !== $this->customPostType) {
            return false;
        }

        $values = get_post_meta(
            $post->ID,
            $this->name,
        );

        if (!empty($values)) {
            // attention wp renvoie un tableau lorsque l'on accède à la valeur d'une métadata
            $value = $values[0];
        } else {
            $value = '';
        }
// Gestion des "demies notes" en V2
        $options = [
            0 => '0',
            1 => '1',
           // 1.5 => '1.5',
            2 => '2',
           // 2.5 => '2.5',
            3 => '3',
          //  3.5 => '3.5',
            4 => '4',
         //  4.5 => '4.5',
            5 => '5',
           
        ];

        echo '
        
        <div class="form-field">';
            echo '<label for="' . $this->name . '">' . $this->label . '</label>';
            echo '<select name="' . $this->name . '" style="">';
                foreach($options as $level => $label) {
                    $selected = '';
                    if($value == $level) {
                        $selected = 'selected';
                    }
                    echo '<option '.$selected.' value="' . $level .'">';
                        echo $label;
                    echo '</option>';
                }
            echo '</select>';
        echo '</div>';

    }
}
