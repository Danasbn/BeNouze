<?php
namespace BeNouze\PostMetadata;

use BeNouze\PostMetadata;

// TODO renommer en BeerPrice !! 
class PriceBeer extends PostMetadata
{
    public function editForm($post)
    {


        $user = wp_get_current_user();
        $roles = $user->roles;

        if(!in_array('administrator', $roles)) {
            return false;
        }
        // ===================================================

        if($post->post_type !== $this->customPostType) {
            return false;
        }

        $values = get_post_meta(
            $post->ID,
            $this->name,
        );

        if(!empty($values)) {

            $value = $values[0];
        }
        else {
            $value = '';
        }

echo '
            <div class="form-field" class="custom-form-field"  style="background-color: #ffa; margin-top: 1rem; padding: 0.5rem">
                <label for="' . $this->name . '">' . $this->label . '</label>
                <input type="text" name="' . $this->name . '" id="' . $this->name . '" value="' . $value . '"/>
            </div>
        ';

    }
}
