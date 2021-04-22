<?php

namespace BeNouze\Controllers;

use WP_Error;
use WP_User;

class UserController extends CoreController
{
    public function signin()
    {
        $templateName = locate_template('template/User/login-form.php');
        $viewVars = [];
        $this->show($templateName, $viewVars);
    }

    public function signup()
    {
        $templateName = locate_template('template/User/register-form.php');
        $viewVars = [];
        $this->show($templateName, $viewVars);
    }

    public function register()
    {
        // DOC https://developer.wordpress.org/reference/functions/wp_registration_url/
        // wp-login.php?action=register


        //2. Add validation. In this case, we make sure first_name is required.
        add_filter('registration_errors', [$this, 'create'], 10, 3);

        //3. Finally, save our extra registration user meta.
        add_action('user_register', [$this, 'userSaveMetadata']);
    }

    public function handleRegistrationErrors($errors, $username, $email)
    {

        // l'adresse est obligatoire ===================================
        $username = filter_input(INPUT_POST, 'username');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if (empty($username)) {
            // DOC https://developer.wordpress.org/reference/classes/wp_error/
            $errors->add(
                'username-error',
                'Merci de préciser un nom d\'utilisateur'
            );
        }

        if (empty($email)) {
            // DOC https://developer.wordpress.org/reference/classes/wp_error/
            $errors->add(
                'useremail-error',
                'Merci de préciser une adresse email'
            );
        }
        if (empty($password)) {
            // DOC https://developer.wordpress.org/reference/classes/wp_error/
            $errors->add(
                'useremail-error',
                'Merci de préciser une mot de passe'
            );
        }


        return $errors;
        $templateName = locate_template('template/User/register-form.php');
        $errors;
        $this->show($templateName, $errors);
    }
    public function create()
    {



        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');
        $email = filter_input(INPUT_POST, 'email');
    

        $userOrError = wp_create_user(
            $login,
            $password,
            $email,
            //$display_name,
        );


        $viewVars = [];

        if ($userOrError instanceof WP_Error) {
             $viewVars['errors'] = $userOrError;
             $templateName = locate_template('template/User/register-form.php'); //! ici que ca bug
             $this->show($templateName, $viewVars);
             return;
        }



        // instanciation du objet wp user
        $userObject = new WP_User($userOrError);

        // Remove role (customer (client) est le rôle par défaut lorsqu'un utilisateur est créé)
        $userObject->remove_role('customer');

      //  wp_redirect(get_home_url() . '/user/signin/');
        exit; 
    }

    

    //! Méthode concernant la page d'accueil
    public function home()
    {

        $templateName = locate_template('index.php');
        $this->show($templateName);
    }
    //!


    //! Méthode concernant la page edit-profile
    public function saveProfile()
    {
        $firstname = filter_input(INPUT_POST, 'first_name');
        $lastname = filter_input(INPUT_POST, 'last_name');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $address = filter_input(INPUT_POST, 'user-address');
        $zipcode = filter_input(INPUT_POST, 'user-codepostal');
        $city = filter_input(INPUT_POST, 'user-city');
        $phone = filter_input(INPUT_POST, 'user-phone');
        $displayname = filter_input(INPUT_POST, 'display_name');
        

        $user = wp_get_current_user();

        // DOC https://developer.wordpress.org/reference/functions/update_user_meta/
        update_user_meta($user->ID, 'user-address', $address);
        update_user_meta($user->ID, 'user-city', $city);
        update_user_meta($user->ID, 'user-codepostal', $zipcode);
        update_user_meta($user->ID, 'user-phone', $phone);
        update_user_meta($user->ID, 'last_name', $lastname);
        update_user_meta($user->ID, 'first_name', $firstname);
        $arguments = array(
            'ID' => $user->id,
            'user_email' => esc_attr($email),
            'user_pass' => esc_attr($password),
            'display_name' => esc_attr($displayname),
            
        );
        wp_update_user($arguments);
        wp_redirect( home_url( 'user/edit-profile/' ) );
    }


    public function editProfile()
    {
        $user = wp_get_current_user();

        $viewVars = [
            'user' => $user
        ];

        $templateName = locate_template('template/User/edit-profile.php');
        $this->show($templateName, $viewVars);
    }


    public function deleteProfileConfirmation()
    {
        
        $templateName = locate_template('template/User/edit-profile-confirmation.php');
        $viewVars = [];
        $this->show($templateName, $viewVars);
        
    }

    public function deleteProfile()
    {
        
        $user = wp_get_current_user();
        
        wp_delete_user($user->ID);

        wp_redirect(get_home_url());
        
    }

}

