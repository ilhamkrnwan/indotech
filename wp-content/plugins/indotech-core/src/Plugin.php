<?php
namespace Indotech\Core;

if (!defined('ABSPATH')) {
    exit;
}

class Plugin {
    /**
     * Singleton instance
     * @var Plugin|null
     */
    private static $instance = null;

    /**
     * Get active singleton instance
     * @return Plugin
     */
    public static function get_instance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor - initialize hooks and modules
     */
    private function __construct() {
        // Boot Carbon Fields
        add_action('after_setup_theme', [$this, 'boot_carbon_fields'], 5);

        // Inisialisasi komponen modular di fase selanjutnya
        $this->init_modules();
    }

    /**
     * Boot Carbon Fields library
     */
    public function boot_carbon_fields() {
        if (class_exists('\\Carbon_Fields\\Carbon_Fields')) {
            \Carbon_Fields\Carbon_Fields::boot();
        }
    }

    /**
     * Initialize modular sub-classes
     */
    private function init_modules() {
        PostTypes::register();
        Taxonomies::register();
        MetaFields::init();
        InquiryHandler::register_ajax();
        AdminDashboard::register();
        RestApi::register();
    }

    /**
     * Plugin Activation Handler
     */
    public static function activate() {
        InquiryHandler::create_table();
        flush_rewrite_rules();
    }

    /**
     * Plugin Deactivation Handler
     */
    public static function deactivate() {
        flush_rewrite_rules();
    }
}
