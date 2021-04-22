<?php

namespace BeNouze\Controllers;

use BeNouze\Models\Beer;
use WP_Query;

class BeerController extends CoreController
{
    public function list()
    {
        $beers = Beer::findAll();

        $viewVars = [
            'beers' => $beers
        ];

        $templateName = locate_template('template/products.php');
        $this->show($templateName, $viewVars);
    }

    
    public function product($id)
    {
        $product = new Beer();
        $product->loadById($id);


        $templateName = locate_template('template/single-product.php');
        $this->show($templateName, [
            'product' => $product
        ]);
    }

    public function breweries()
    {
        $templateName = locate_template('template/brasserie.php');
        $this->show($templateName);
    }

    public function ourValues()
    {
        $templateName = locate_template('template/about.php');
        $this->show($templateName);
    }

    public function legalNotices()
    {
        $templateName = locate_template('legal-terms.php');
        $this->show($templateName);
    }

    public function privacyPolicy()
    {
        $templateName = locate_template('confidentiality-terms.php');
        $this->show($templateName);
    }

    public function about()
    {
        $templateName = locate_template('template/about.php');
        $this->show($templateName);
    }

    public function error()
    {
        $templateName = locate_template('404.php');
        $this->show($templateName);
    }
    public function filter()
    {
  
        $filters = [];


        $criterias =  [
            'style',
            'color',
            'degre',
            //'price', for V2
        ];

        foreach ($criterias as $criteria) {
            if ($value = filter_input(INPUT_GET, $criteria)) {
                $filters[] = [
                    'taxonomy' => $criteria,
                    'field'    => 'slug',
                    'terms'    => array($value),
                ];
            }
        }
        $args = array(
            'post_type' => 'beer',
            'posts_per_page' => '-1',
            'tax_query' => array(
                'relation' => 'AND',
                $filters
            ),
        );
        $query = new WP_Query($args);

        $templateName = locate_template('beer-filter.php');
       
        $beers = $query->get_posts();

        $this->show($templateName, [
            'beers' => $beers
        ]);

    

    }
}
