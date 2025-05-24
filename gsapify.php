<?php
/**
 * Plugin Name:       GSAPify
 * Description:       A developer-friendly block for adding GSAP animations to your content.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:          0.1.0
 * Author:           John-Paul Takats
 * License:          GPL-2.0-or-later
 * License URI:      https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:      gsapify
 *
 * @package          create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Include settings
require_once plugin_dir_path( __FILE__ ) . 'includes/settings.php';

/**
 * Get GSAP plugin dependencies
 */
function gsapify_get_plugin_dependencies() {
    return array(
        'ScrollSmoother' => array('ScrollTrigger'),
        'CustomBounce' => array('CustomEase'),
        'CustomWiggle' => array('CustomEase')
    );
}

/**
 * Enqueue GSAP and its plugins
 */
function gsapify_enqueue_gsap() {
    if (has_block('create-block/gsapify')) {
        // Get enabled plugins
        $enabled_plugins = gsapify_get_enabled_plugins();
        $dependencies = gsapify_get_plugin_dependencies();
        $skip_main = gsapify_skip_main_library();
        
        $gsap_handle = 'gsap';
        $gsap_deps = array();
        
        // Add core GSAP if not skipped
        if (!$skip_main) {
            wp_enqueue_script(
                'gsap',
                'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/gsap.min.js',
                array(),
                '3.13.0',
                true
            );
        } else {
            // When skipping, we'll use a dummy handle for dependencies
            $gsap_handle = 'gsap-dummy';
            wp_register_script($gsap_handle, false);
        }

        // If we have plugins to load
        if (!empty($enabled_plugins)) {
            // Add dependencies first
            $processed_plugins = array();
            foreach ($enabled_plugins as $plugin) {
                if (isset($dependencies[$plugin])) {
                    foreach ($dependencies[$plugin] as $dependency) {
                        if (!in_array($dependency, $processed_plugins)) {
                            wp_enqueue_script(
                                'gsap-' . strtolower($dependency),
                                'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/' . $dependency . '.min.js',
                                array($gsap_handle),
                                '3.13.0',
                                true
                            );
                            $processed_plugins[] = $dependency;
                        }
                    }
                }
            }

            // Add enabled plugins
            foreach ($enabled_plugins as $plugin) {
                if (!in_array($plugin, $processed_plugins)) {
                    wp_enqueue_script(
                        'gsap-' . strtolower($plugin),
                        'https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/' . $plugin . '.min.js',
                        array($gsap_handle),
                        '3.13.0',
                        true
                    );
                    $processed_plugins[] = $plugin;
                }
            }

            // Add plugin registration script if we have plugins to register
            if (!empty($processed_plugins)) {
                $script_handle = $skip_main ? 'gsap-dummy' : 'gsap';
                wp_add_inline_script($script_handle, '
                    document.addEventListener("DOMContentLoaded", function() {
                        if (typeof gsap !== "undefined") {
                            gsap.registerPlugin(' . implode(',', $processed_plugins) . ');
                        }
                    });
                ');
            }
        }
    }
}
add_action('wp_enqueue_scripts', 'gsapify_enqueue_gsap');

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_gsapify_block_init() {
    // Include the render.php file
    require_once plugin_dir_path( __FILE__ ) . 'build/gsapify/render.php';
    
    // Register the block with the render callback
    register_block_type( 
        __DIR__ . '/build/gsapify',
        array(
            'render_callback' => 'render_block_gsapify'
        )
    );
}
add_action( 'init', 'create_block_gsapify_block_init' );
