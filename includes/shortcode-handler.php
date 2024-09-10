<?php

// Shortcode handler
function veriscan_render_form() {
    // Get selected template
    $selected_template = get_option('veriscan_selected_template', 'template-1');
    
    ob_start();
    include plugin_dir_path(__FILE__) . '../templates/' . $selected_template . '.php';
    return ob_get_clean();
}

// Handle AJAX Request
function veriscan_ajax_callback() {
    $api_url = get_option('veriscan_api_endpoint');
    $code = sanitize_text_field($_POST['code']);

    // Perform API call to the endpoint
    $response = wp_remote_post($api_url, array(
        'body' => array('code' => $code),
    ));
    
    // Check for API response errors
    if (is_wp_error($response)) {
        wp_send_json_error('Error with API request');
    }

    $body = wp_remote_retrieve_body($response);
    wp_send_json_success($body);
}
add_action('wp_ajax_veriscan_check_code', 'veriscan_ajax_callback');
add_action('wp_ajax_nopriv_veriscan_check_code', 'veriscan_ajax_callback');