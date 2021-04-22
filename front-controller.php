<?php

use BeNouze\Controllers\UserController;
use BeNouze\Controllers\BeerController;
use BeNouze\Controllers\TestController;



require_once(ABSPATH.'wp-admin/includes/user.php');


$router = new AltoRouter();
$basePath = dirname($_SERVER['SCRIPT_NAME']);
$router->setBasePath($basePath);

$router->map(
    'GET',
    '/product/[i:id]/',
    function($id) {
        $controller = new BeerController();
        $controller-> product($id);
    }
);
$router->map(
    'GET',
    '/beer/filter/',
    function () {
        $controller = new BeerController();
        $controller->filter();
        
    },

);

$router->map(
    'POST',
    '/benouze/rating/[i:id]/',
    function ($id) {
        
        echo '<div style="border: solid 2px #F00">';
            echo '<div style="; background-color:#CCC">@'.__FILE__.' : '.__LINE__.'</div>';
            echo '<pre style="background-color: rgba(255,255,255, 0.8);">';
            print_r($_POST);
            echo '</pre>';
        echo '</div>';

        echo __FILE__.':'.__LINE__; exit();
        $controller = new BeerController();
        $controller->product($id);
    }
);





$match = $router->match();

// DOC https://altorouter.com/usage/matching-requests.html 
if($match) {
    call_user_func_array($match['target'], $match['params']);
    // TODO attention à ne pas laisser le exit ; mis ici pour ne pas créer d'incompatibilité avec la suite
    exit();
}


//===========================================================
// Récupération de la méthode HTTP utilisée pour accéder à la page
$requestMethod = $_SERVER['REQUEST_METHOD'];

$routeName = get_query_var('custom-route');


if($routeName === 'user-edit-profile') {
    $controller = new UserController();
    if($requestMethod === 'GET') {
        $controller->editProfile();
    }
    elseif($requestMethod === 'POST') {
        $controller->saveProfile();
    }
}

elseif($routeName === 'user-delete') {
    $controller = new UserController();
    $controller->deleteProfile();
}
elseif($routeName === 'user-delete-confirmation') {
    $controller = new UserController();
    $controller->deleteProfileConfirmation();
}

elseif($routeName === 'user-signup') {
    $controller = new UserController();
    if($requestMethod === 'GET') {
        $controller->signup();
    }
    elseif($requestMethod === 'POST') {
        $controller->create();
    }
} elseif ($routeName === 'user-signin') {
    $controller = new UserController();
    $controller->signin();
    
}  elseif ($routeName === 'beer-filter') {
    $controller = new BeerController();
    $controller->filter();
}elseif ($routeName === 'test-sandbox') {
     $controller = new TestController();
     $controller->sandbox();
 }

else {
    die('fail');
}
