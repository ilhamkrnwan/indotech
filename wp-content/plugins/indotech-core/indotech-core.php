<?php
/**
 * Plugin Name: Indotech Core
 * Description: Core Business Logic, Custom Post Types, Custom Databases, and REST API for PT Indotech Berkah Abadi.
 * Version: 1.0.0
 * Author: PT Indotech Berkah Abadi
 * License: GPL2
 * Text Domain: indotech-core
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Load Composer Autoloader
$composer_autoload = dirname(__FILE__) . '/vendor/autoload.php';
if (file_exists($composer_autoload)) {
    require_once $composer_autoload;
}

// Hook activation and deactivation
register_activation_hook(__FILE__, [ 'Indotech\\Core\\Plugin', 'activate' ]);
register_deactivation_hook(__FILE__, [ 'Indotech\\Core\\Plugin', 'deactivate' ]);

// Initialize the plugin after all plugins are loaded
add_action('plugins_loaded', [ 'Indotech\\Core\\Plugin', 'get_instance' ]);
