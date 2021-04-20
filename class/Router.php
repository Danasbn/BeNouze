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
            'user/edit-profile/?$',   // regexp
            'index.php?custom-route=user-edit-profile',  // vers quel "format virtuel" wordpress va transformer l'url demandée
            'top'   // la route se mettra en haut de la pile de priorités des routes enregistrées par wordpress
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
        //! NE PAS TESTER //!
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

        // //! Route PRODUCTS LIST
        // add_rewrite_rule(
        //     'products/list/?$',
        //     'index.php?custom-route=products-list',
        //     'top'
        // );

        // //! Route PRODUCT
        // add_rewrite_rule(
        //     'product/?',
        //     'index.php?custom-route=product',
        //     'top'
        // );

        // //! Route BREWERY
        // add_rewrite_rule(
        //     'breweries/?$',
        //     'index.php?custom-route=breweries',
        //     'top'
        // );

        // //! Route OUR VALUES
        // add_rewrite_rule(
        //     'our-values/?$',
        //     'index.php?custom-route=our-values',
        //     'top'
        // );

        //  //! Route LEGAL NOTICES
        //  add_rewrite_rule(
        //     'legal-notices/?$',
        //     'index.php?custom-route=legal-notices',
        //     'top'
        // );

        // //! Route PRIVACY POLICY
        // add_rewrite_rule(
        //     'privacy-policy/?$',
        //     'index.php?custom-route=privacy-policy',
        //     'top'
        // );

        // //! Route ABOUT
        // add_rewrite_rule(
        //     'about/?$',
        //     'index.php?custom-route=about',
        //     'top'
        // );

        // //! Route 404
        // add_rewrite_rule(
        //     '404/?$',
        //     'index.php?custom-route=404',
        //     'top'
        // );


        

        // nous demandons à wp de supprimer le cache des routes. Wordpress gère les routes en base de donnée. Attention ici le flush_rewrite_rules est "bourrin" ; il faudrait "casser le cache des routes" L'endoit moment idéal  serait au moment de l'activation du plugin
        flush_rewrite_rules();


        // nous demandons à wordpress d'enregistrer dans les paramètre envoyés, la "fausse variable GET" custom-route
        add_filter('query_vars', function ($query_vars) {
            $query_vars[] = 'custom-route';
            return $query_vars;
        });


        // ce hook permet à wordpress de savoir quel fichier il va utiliser en tant que template
        // le paramètre $template est le template que wordpress compte utiliser
        add_action('template_include', function($template) {

            // récupération de la variable "vituelle get" enregistrée par wordpress
            // DOC https://developer.wordpress.org/reference/functions/get_query_var/
            // équivalent à $_GET['custom-route'];
            $customRouteName = get_query_var('custom-route');

            // si le paramètre $customRouteName vaut test; nous décidons d'afficher le template page-test
            if(
                
                $customRouteName === 'benouze'


                || $customRouteName === 'user-edit-profile'
                || $customRouteName === 'user-signup'
                || $customRouteName === 'user-signin'
                || $customRouteName === 'user-delete'
                || $customRouteName === 'test-sandbox'
                || $customRouteName === 'beer-filter'
                || $customRouteName === 'user-delete-confirmation'
                // $customRouteName === 'home'
                // || $customRouteName === 'products-list'
                // || $customRouteName === 'product'
                // || $customRouteName === 'breweries'
                // || $customRouteName === 'about'
                // || $customRouteName === 'our-values'
                // || $customRouteName === 'legal-notices'
                // || $customRouteName === 'privacy-policy'
                // || $customRouteName === '404'
              
            ) {

                return BENOUZE_FILEPATH . '/front-controller.php';

            }

            // sinon ; on affiche le template que wordpress comptait utiliser
            return $template;

        });

    }
}
