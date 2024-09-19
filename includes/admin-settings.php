<?php
// Create a menu page in WordPress dashboard for setting API endpoint and template selection
function veriscan_create_admin_menu() {
    add_menu_page(
        'Veriscan Settings',
        'Veriscan',
        'manage_options',
        'veriscan-settings',
        'veriscan_settings_page',
        'dashicons-admin-generic'
    );
}
add_action('admin_menu', 'veriscan_create_admin_menu');

// Admin page content with tabs for API endpoint and template selection
function veriscan_settings_page() {
    // Handle form submission for API endpoint
    if (isset($_POST['veriscan_api_endpoint'])) {
        update_option('veriscan_api_endpoint', sanitize_text_field($_POST['veriscan_api_endpoint']));
    }

    // Handle form submission for template selection
    if (isset($_POST['veriscan_selected_template'])) {
        update_option('veriscan_selected_template', sanitize_text_field($_POST['veriscan_selected_template']));
    }

    // Get current values
    $veriscan_api_endpoint = get_option('veriscan_api_endpoint', '');
    $selected_template = get_option('veriscan_selected_template', 'template-1');

    ?>
<style>
/* Ensure all cards have the same height */
.card {
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Style for the form-check */
.form-check-input {
    width: 20px;
    height: 20px;
}

/* Center the radio buttons */
.form-check {
    display: flex;
    justify-content: center;
    align-items: center;
}

.submit-btn {
    margin-top: 50px;
}
</style>
<div class="wrap">
    <h1>Veriscan Settings</h1>

    <!-- Bootstrap nav-tabs -->
    <ul class="nav nav-tabs" id="veriscanTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="api-tab" data-toggle="tab" href="#api" role="tab" aria-controls="api"
                aria-selected="true">API Endpoint</a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template"
                aria-selected="false">Template Selection</a>
        </li> -->
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="veriscanTabContent">
        <!-- API Endpoint Settings (Tab 1) -->
        <div class="tab-pane fade show active" id="api" role="tabpanel" aria-labelledby="api-tab">
            <form method="post" action="" class="mt-4 w-50 p-3">
                <div class="form-group">
                    <label for="veriscan_api_endpoint">API Endpoint URL</label>
                    <input type="text" name="veriscan_api_endpoint" id="veriscan_api_endpoint" class="form-control"
                        value="<?php echo esc_attr($veriscan_api_endpoint); ?>" />
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>

            <!-- Code line bar for the veriscan_code shortcode -->
            <div class="mt-4">
                <label for="veriscan_code">Veriscan Code Shortcode</label>
                <p>Use this shortcode to implement the code line bar:</p>
                <p>If you're unsure how to implement it, you can watch the demo <a
                        href="https://www.youtube.com/watch?v=iS1FFahiAbk" target="_blank">here</a>.</p>
                <pre><code id="veriscan_code">[veriscan_code]</code></pre>
            </div>
        </div>
    </div>
</div>
<?php
}