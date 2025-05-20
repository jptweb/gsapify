<?php
/**
 * GSAPify Settings
 *
 * @package GSAPify
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Add settings page
 */
function gsapify_add_settings_page() {
    add_options_page(
        'GSAPify Settings',
        'GSAPify',
        'manage_options',
        'gsapify-settings',
        'gsapify_settings_page'
    );
}
add_action( 'admin_menu', 'gsapify_add_settings_page' );

/**
 * Register settings
 */
function gsapify_register_settings() {
    register_setting( 'gsapify_settings', 'gsapify_plugins', array(
        'type' => 'array',
        'sanitize_callback' => 'gsapify_sanitize_plugins',
        'default' => array()
    ) );
}
add_action( 'admin_init', 'gsapify_register_settings' );

/**
 * Sanitize plugins array
 */
function gsapify_sanitize_plugins( $plugins ) {
    if ( ! is_array( $plugins ) ) {
        return array();
    }
    return array_map( 'sanitize_text_field', $plugins );
}

/**
 * Get enabled plugins
 */
function gsapify_get_enabled_plugins() {
    $plugins = get_option( 'gsapify_plugins' );
    return is_array( $plugins ) ? $plugins : array();
}

/**
 * Settings page content
 */
function gsapify_settings_page() {
    $plugins = gsapify_get_enabled_plugins();
    ?>
    <div class="wrap">
        <h1>GSAPify Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields( 'gsapify_settings' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">GSAP Plugins</th>
                    <td>
                        <fieldset>
                            <legend class="screen-reader-text">Select GSAP plugins to enable</legend>
                            <?php
                            $available_plugins = array(
                                'Draggable' => 'Draggable',
                                'EaselPlugin' => 'Easel',
                                'Flip' => 'Flip',
                                'InertiaPlugin' => 'Inertia',
                                'MotionPathHelper' => 'MotionPathHelper',
                                'MotionPathPlugin' => 'MotionPath',
                                'MorphSVGPlugin' => 'MorphSVG',
                                'Observer' => 'Observer',
                                'PhysicsPropsPlugin' => 'PhysicsProps',
                                'PixiPlugin' => 'Pixi',
                                'ScrollTrigger' => 'ScrollTrigger',
                                'ScrollSmoother' => 'ScrollSmoother',
                                'SplitText' => 'SplitText',
                                'TextPlugin' => 'Text',
                                'EasePack' => 'Eases (includes RoughEase, ExpoScaleEase, SlowMo)',
                                'CustomEase' => 'CustomEase',
                                'CustomBounce' => 'CustomBounce',
                                'CustomWiggle' => 'CustomWiggle'
                            );

                            foreach ( $available_plugins as $plugin_key => $plugin_name ) {
                                ?>
                                <label>
                                    <input type="checkbox" 
                                           name="gsapify_plugins[]" 
                                           value="<?php echo esc_attr( $plugin_key ); ?>"
                                           <?php checked( in_array( $plugin_key, $plugins ), true ); ?>>
                                    <?php echo esc_html( $plugin_name ); ?>
                                </label><br>
                                <?php
                            }
                            ?>
                        </fieldset>
                        <p class="description">Select the GSAP plugins you want to enable. Only selected plugins will be loaded when needed.</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
} 