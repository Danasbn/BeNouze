<?php
// cette classe va nous permettre de gérer notre plugin

namespace BeNouze;

use BeNouze\CustomPostType;
use BeNouze\CustomTaxonomy;
use BeNouze\CustomPostType\Beer;
use BeNouze\PostMetadata\PriceBeer;
use BeNouze\PostMetadata\BeerReviews;


class Plugin
{

    public function __construct()
    {
        
        $this->registerCustomPostTypes();
        $this->registerPostMetadatas();
        
        $this->registerCustomTaxonomies();
        /*
        $this->registerTaxonomiesMetadata();
        */
        $this->createCustomRoles();


        /*$this->customizeRegistrationForm();*/
     
        $this->registerUserMetadata();

        $this->registerRouter();
        
    }

    public function registerRouter()
    {
        $router = new Router();
        $router->register();
    }


    public function registerUserMetadata()
    {
        $userAddress = new UserMetadata('user-address', 'Adresse');
        $userAddress->register();

        $userCodepostal = new UserMetadata('user-codepostal', 'Code Postal');
        $userCodepostal->register();

        $userCity = new UserMetadata('user-city', 'Ville');
        $userCity->register();

        $userPhone = new UserMetadata('user-phone', 'Telephone');
        $userPhone->register();
    }

    /*
    public function customizeRegistrationForm()
    {
        $registrationForm = new RegistrationForm();
        $registrationForm->register();

    }
    */
/*
    public function registerTaxonomiesMetadata()
    {
        $skillLogo = new TaxonomyMetadata('skill', 'skill-logo', 'URL Logo');
        $skillLogo->register();

    }
    */

     public function createCustomPostTypes()
    {
        register_post_type(
            'beer',    // identifiant du cpt
            [
                'label' => 'Bières',
                'public' => true,   // le cpt pourra être édité depuis le bo
                'hierarchical' => false,
                'show_in_rest' =>  true,    // notre cpt sera accessible depuis l'api rest de wp
                'menu_position' => 4,
                'menu_icon' => 'dashicons-products',
                'supports' => [
                    'title',
                    'editor',
                    'thumbnail',
                    'excerpt',
                    'author',
                    'comments',
                    'custom-fields',

                ]
            ]
        );
    }
    public function registerCustomPostTypes()
    {
        $beer = new CustomPostType('beer', 'Bieres');
        $beer->register();



    }

    public function registerCustomTaxonomies()
    {
        $style = new CustomTaxonomy('style', 'Style', ['beer']);
        $style->register();

        $color = new CustomTaxonomy('color', 'Couleur', ['beer']);
        $color->register();

        $degre = new CustomTaxonomy('degre', 'Degré', ['beer']);
        $degre->register();


    }


    public function createCustomRoles()
    {
        //===========================================================
        // Configuration du rôle client (customer)
        //===========================================================

        $customerRole = new CustomRole('customer-role', 'Client');
        $customerRole->register();

        
        // on donnne les droits (capabilities) au rôle customer
        $role = get_role('customer-role');

        // ajout des autorisations au rôle

        $role->add_cap('read');

        //$role->add_cap('edit_developer');
        //$role->add_cap('edit_developers');
        //$role->add_cap('read_developers');
        //$role->add_cap('delete_developers');
        //$role->add_cap('delete_published_developers');
        //$role->add_cap('delete_others_developers');
        //$role->add_cap('edit_others_developers');
        //$role->add_cap('publish_developers');
        //$role->add_cap('read_private_developers');
        
        //$role->remove_cap('delete_others_posts');
        //$role->remove_cap('delete_posts');
        //$role->remove_cap('delete_private_posts');
        //$role->remove_cap('delete_published_posts');
        //$role->remove_cap('edit_others_posts');
        //$role->remove_cap('edit_posts');
        //$role->remove_cap('edit_private_posts');
        //$role->remove_cap('edit_published_posts');
        //$role->remove_cap('manage_categories');
        //$role->remove_cap('moderate_comments');
        //$role->remove_cap('publish_posts');
        //$role->remove_cap('read_private_posts');

        //===========================================================
        //===========================================================

    }

    

    public function registerPostMetadatas()
    {
        /*
        $githubURL = new PostMetadata(
            // le custom post type  sur lequel ajouter le champs supplémentaire
            'developer',

            // l'identifiant (la variable) qui va nous nous permettre de stocker l'information
            'github-profile-url',

            // libéllé
            'Github profile URL'
        );
        $githubURL->register();

        */

        $pricebeer = new PriceBeer(
            'beer',
            'price',
            'Prix'
        );
        $pricebeer->register();

        $pricebeer = new PriceBeer(
            'beer',
            'alcohol',
            'Degré alcool'
        );
        $pricebeer->register();

        $generalReview = new BeerReviews(
            'beer',
            'generalReview',
            'Note générale'
        );
        $generalReview->register();


        $bitterness = new BeerReviews(
                'beer',
                'bitterness',
                'Amertume'
            );
        $bitterness->register();

        $acidity = new BeerReviews(
            'beer',
            'acidity',
            'Acidité'
        );
        $acidity->register();
        $fruity = new BeerReviews(
            'beer',
            'fruity',
            'Fruité'
        );
        $fruity->register();

        
    }
    


    // appelé lors de la désinstallation du plugin
    public function uninstall()
    {

    }


    // appelé lorsque le plugin est désactivé
    public function deactivate()
    {
        
    }


    // appelé lorsque le plugin est activé
    public function activate()
    {
      
    }

    public function flushRoutes()
    {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

}