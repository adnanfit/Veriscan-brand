<?php
// Prevent direct file access
if (!defined('ABSPATH')) {
    exit;
}

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

function veriscan_settings_page() {
    // Check user capabilities
    if (!current_user_can('manage_options')) {
        return;
    }

    // Save settings if the form is submitted
    if (isset($_POST['veriscan_save_settings'])) {
        if (isset($_POST['veriscan_brand_id'])) {
            update_option('veriscan_brand_id', sanitize_text_field($_POST['veriscan_brand_id']));
        }
        if (isset($_POST['veriscan_selected_template'])) {
            update_option('veriscan_selected_template', sanitize_text_field($_POST['veriscan_selected_template']));
        }
        add_settings_error('veriscan_messages', 'veriscan_message', __('Settings Saved', 'veriscan'), 'updated');
    }

    // Get current settings
    $veriscan_brand_id = get_option('veriscan_brand_id', '');
    $veriscan_selected_template = get_option('veriscan_selected_template', 'template-1');

    // Define available templates
    $plugin_dir = plugin_dir_url(dirname(__FILE__));
    $templates = [
        'template-1' => [
            'name' => 'Template 1',
            'image' => $plugin_dir . 'assets/images/template-1.png',
            'file' => plugin_dir_path(dirname(__FILE__)) . 'templates/template-1.php'
        ],
        'template-2' => [
            'name' => 'Template 2',
            'image' => $plugin_dir . 'assets/images/template-2.png',
            'file' => plugin_dir_path(dirname(__FILE__)) . 'templates/template-2.php'
        ],
        'template-3' => [
            'name' => 'Template 3',
            'image' => $plugin_dir . 'assets/images/template-3.png',
            'file' => plugin_dir_path(dirname(__FILE__)) . 'templates/template-3.php'
        ],
    ];

    // Settings page HTML
    ?>
<div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php settings_errors('veriscan_messages'); ?>

    <form method="post" action="">
        <?php wp_nonce_field('veriscan_settings_action', 'veriscan_settings_nonce'); ?>

        <h2 class="nav-tab-wrapper">
            <a href="#brand-id" class="nav-tab nav-tab-active">Brand ID</a>
            <a href="#template" class="nav-tab">Select Template</a>
        </h2>

        <div id="brand-id" class="tab-content">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Brand ID</th>
                    <td>
                        <input type="text" name="veriscan_brand_id" value="<?php echo esc_attr($veriscan_brand_id); ?>"
                            class="regular-text">
                        <p class="description">Enter your Veriscan Brand ID here.</p>
                    </td>
                </tr>
            </table>
        </div>

        <div id="template" class="tab-content" style="display:none;">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Select Template</th>
                    <td>
                        <div class="template-container">
                            <?php foreach ($templates as $key => $template): ?>
                            <div
                                class="template-card <?php echo ($veriscan_selected_template === $key) ? 'selected' : ''; ?>">
                                <label>
                                    <input type="radio" name="veriscan_selected_template"
                                        value="<?php echo esc_attr($key); ?>"
                                        <?php checked($veriscan_selected_template, $key); ?>>
                                    <img src="<?php echo esc_url($template['image']); ?>"
                                        alt="<?php echo esc_attr($template['name']); ?>">
                                    <p><?php echo esc_html($template['name']); ?></p>
                                </label>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <?php submit_button('Save Settings', 'primary', 'veriscan_save_settings'); ?>
    </form>

    <div class="postbox">
        <h3 class="hndle"><span>Shortcode Usage</span></h3>
        <div class="inside">
            <p>Use this shortcode to implement the Veriscan code form on your pages or posts:</p>
            <code>[veriscan_code]</code>
        </div>
    </div>
</div>

<style>
.template-container {
    display: flex;
    flex-wrap: nowrap;
    gap: 20px;
}

.template-card {
    display: flex;
    align-items: center;
    width: 350px;
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
    cursor: pointer;
    transition: all 0.3s ease;
}

.template-card:hover,
.template-card.selected {
    border-color: #007cba;
    box-shadow: 0 0 5px rgba(0, 124, 186, 0.8);
}

.template-card img {
    max-width: 100%;
    height: auto;
}

.template-card input[type="radio"] {
    display: none;
}

.tab-content {
    margin-top: 20px;
}
</style>

<script>
jQuery(document).ready(function($) {
    // Tab functionality
    $('.nav-tab-wrapper a').on('click', function(e) {
        e.preventDefault();
        $('.nav-tab-wrapper a').removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');
        $('.tab-content').hide();
        $($(this).attr('href')).show();
    });

    // Template selection
    $('.template-card').on('click', function() {
        $('.template-card').removeClass('selected');
        $(this).addClass('selected');
        $(this).find('input[type="radio"]').prop('checked', true);
    });
});
</script>
<?php
}

// Shortcode implementation
function veriscan_code_shortcode() {
    $selected_template = get_option('veriscan_selected_template', 'template-1');
    $template_file = plugin_dir_path(dirname(__FILE__)) . 'templates/' . $selected_template . '.php';
    
    if (file_exists($template_file)) {
        ob_start();
        include $template_file;
        return ob_get_clean();
    } else {
        return '<!-- Veriscan Error: Template file not found. -->';
    }
}
add_shortcode('veriscan_code', 'veriscan_code_shortcode');