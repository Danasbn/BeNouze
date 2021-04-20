<?php

namespace BeNouze;

class UserMetadata
{
    protected $name;
    protected $label;

    public function __construct($name, $label)
    {
        $this->name = $name;
        $this->label = $label;
    }

    public function register()
    {
        add_action('show_user_profile',[$this, 'displayEditForm']);
        add_action('edit_user_profile',[$this, 'displayEditForm']);

        add_action('edit_user_profile_update', [$this, 'update']);
        add_action('personal_options_update', [$this, 'update']);
    }

    public function displayEditForm($user)
    {
        //https://developer.wordpress.org/reference/functions/get_user_meta/
        $value = get_user_meta(
            $user->data->ID,
            $this->name,
            true
        );

        echo '
        <div class="form-field">
            <label for="' . $this->name . '">' . $this->label. '</label>
            <textarea name="' . $this->name . '" id="' . $this->name . '">' . $value . '</textarea>
        </div>
      ';
    }


    public function update($userId)
    {
        $value = filter_input(INPUT_POST, $this->name);
        // DOC https://developer.wordpress.org/reference/functions/update_user_meta/
        update_user_meta(
            $userId,
            $this->name,
            $value
        );
    }
}


