<?php
/**
 * Plugin Name: BeNouze The Plugin
 *  Author: BeNouze Team
 */

use BeNouze\Plugin;

require __DIR__ . '/static-vendor/autoload.php';

define('BENOUZE_FILEPATH', __DIR__);

$plugin = new Plugin();
// WARNING attention il faut mettre  __FILE__ le fichier qui gère le plugin
register_activation_hook(__FILE__, [$plugin, 'activate']);
register_deactivation_hook(__FILE__, [$plugin, 'deactivate']);

add_action('init', [$plugin, 'registerCustomPostTypes']);
add_action('init', [$plugin, 'createCustomPostTypes'], 50);


