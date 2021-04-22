<?php
namespace BeNouze;

use BeNouze\Controllers\UserController;

class Router
{
    public function __construct()
    {

    }

    public function register()
    {
        add_action('init', [$this, 'registerRoutes']);
    }

    public function registerRoutes()
    {

        //! Route pour notations, mis de coté pour le moment
        add_rewrite_rule(
            'benouze/rating/?',   // regexp
            'index.php?custom-route=benouze',  // vers quel "format virtuel" wordpress va transformer l'url demandée
            'top'   // la route se mettra en haut de la pile de priorités des routes enregistrées par wordpress
        );
        //! route SANDBOX
        add_rewrite_rule(
            'test/sandbox/?$',
            'index.php?custom-route=test-sandbox',
            'top'
        );

        //! Route EDIT PROFILE
        add_rewrite_rule(
            'user/edit-profile/?$',   
            'index.php?custom-route=user-edit-profile', 
            'top'   
        );

        //! Route SIGNUP
        add_rewrite_rule(
            'user/signup/?$',
            'index.php?custom-route=user-signup',
            'top'
        );

        //! Route SIGNIN
        add_rewrite_rule(
            'user/signin/?$',
            'index.php?custom-route=user-signin',
            'top'
        );

        //! Route Delete confirmation
        add_rewrite_rule(
            'user/delete-profile/confirmation/?$',
            'index.php?custom-route=user-delete-confirmation',
            'top'
        );

        //! Route DELETE PROFILE
        //! NE PAS TESTER SUR PROFILE ADMIN //!
        add_rewrite_rule(
            'user/delete-profile/?$',
            'index.php?custom-route=user-delete',
            'top'
        );
        //! Route FILTER
        add_rewrite_rule(
            'beer/filter/?',
            'index.php?custom-route=beer-filter',
            'top'
        );
       

        // nous demandons à wp de supprimer le cache des routes. Wordpress gère les routes en base de donnée. 


        // nous demandons à wordpress d'enregistrer dans les paramètre envoyés, la "fausse variable GET" custom-route
        add_filter('query_vars', function ($query_vars) {
            $query_vars[] = 'custom-route';
            return $query_vars;
        });


        // ce hook permet à wordpress de savoir quel fichier il va utiliser en tant que template
        // le paramètre $template est le template que wordpress compte utiliser
        add_action('template_include', function($template) {

            // récupération de la variable "virtuelle get" enregistrée par wordpress
            // DOC https://developer.wordpress.org/reference/functions/get_query_var/
            // équivalent à $_GET['custom-route'];
            $customRouteName = get_query_var('custom-route');

            if(
                
                $customRouteName === 'benouze'


                || $customRouteName === 'user-edit-profile'
                || $customRouteName === 'user-signup'
                || $customRouteName === 'user-signin'
                || $customRouteName === 'user-delete'
                || $customRouteName === 'test-sandbox'
                || $customRouteName === 'beer-filter'
                || $customRouteName === 'user-delete-confirmation'
              
              
            ) {

                return BENOUZE_FILEPATH . '/front-controller.php';

            }

            return $template;

        });

    }
}
