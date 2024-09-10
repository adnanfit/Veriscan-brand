<?php
/**
 * Plugin Name: Veriscan
 * Description: A form-based plugin for code verification with AJAX and template support.
 * Version: 1.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Enqueue necessary scripts and styles
function veriscan_enqueue_scripts() {
    wp_enqueue_style('veriscan-styles', plugin_dir_url(__FILE__) . 'assets/css/form-styles.css');
    wp_enqueue_script('veriscan-ajax', plugin_dir_url(__FILE__) . 'assets/js/veriscan-ajax.js', array('jquery'), null, true);
    
    // Pass AJAX URL to script
    wp_localize_script('veriscan-ajax', 'veriscan_ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'api_endpoint' => get_option('veriscan_api_endpoint'),
        'pluginUrl' => plugin_dir_url(__FILE__)

    ));
}
add_action('wp_enqueue_scripts', 'veriscan_enqueue_scripts');

function veriscan_enqueue_admin_scripts() {
    // Enqueue Bootstrap CSS and JS for admin pages
    wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'veriscan_enqueue_admin_scripts');

// Include other necessary files
include_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
include_once plugin_dir_path(__FILE__) . 'includes/shortcode-handler.php';


// Register shortcode
add_shortcode('veriscan_code', 'veriscan_render_form');