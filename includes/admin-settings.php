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
        <li class="nav-item">
            <a class="nav-link" id="template-tab" data-toggle="tab" href="#template" role="tab" aria-controls="template"
                aria-selected="false">Template Selection</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="veriscanTabContent">
        <!-- API Endpoint Settings (Tab 1) -->
        <div class="tab-pane fade show active" id="api" role="tabpanel" aria-labelledby="api-tab">
            <form method="post" action="" class="mt-4">
                <div class="form-group">
                    <label for="veriscan_api_endpoint">API Endpoint URL</label>
                    <input type="text" name="veriscan_api_endpoint" id="veriscan_api_endpoint" class="form-control"
                        value="<?php echo esc_attr($veriscan_api_endpoint); ?>" />
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>

        <!-- Template Selection (Tab 2) -->
        <div class="tab-pane fade" id="template" role="tabpanel" aria-labelledby="template-tab">
            <form method="post" action="" class="mt-4">
                <h4>Select a Template</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <!-- Correct image path -->
                            <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/images/template-1.png'; ?>"
                                class="card-img-top" alt="Template 1">
                            <div class="card-body">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="radio" name="veriscan_selected_template"
                                        id="template-1" value="template-1"
                                        <?php checked($selected_template, 'template-1'); ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <img src="<?php echo plugin_dir_url(__FILE__) . '../assets/images/template-2.png'; ?>"
                                class="card-img-top" alt="Template 2">
                            <div class="card-body">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="radio" name="veriscan_selected_template"
                                        id="template-2" value="template-2"
                                        <?php checked($selected_template, 'template-2'); ?>>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card text-center shadow-sm">
                            <img src="<?php echo plugin_dir_url(__FILE__) . 'assets/images/template-3.png'; ?>"
                                class="card-img-top" alt="Template 3">
                            <div class="card-body">
                                <div class="form-check mt-3">
                                    <input class="form-check-input" type="radio" name="veriscan_selected_template"
                                        id="template-3" value="template-3"
                                        <?php checked($selected_template, 'template-3'); ?>>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-btn">
                    <!-- Save button -->
                    <button type="submit" class="btn btn-primary ">Save Template</button>
                </div>
            </form>

        </div>
    </div>
</div>
<?php
}