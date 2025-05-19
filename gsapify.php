<?php
/**
 * Plugin Name:       GSAPify
 * Description:       A developer-friendly block for adding GSAP animations to your content.
 * Requires at least: 6.1
 * Requires PHP:      7.0
 * Version:          0.1.0
 * Author:           Your Name
 * License:          GPL-2.0-or-later
 * License URI:      https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:      gsapify
 *
 * @package          create-block
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue GSAP from CDN
 */
function gsapify_enqueue_gsap() {
    if (has_block('create-block/gsapify')) {
        wp_enqueue_script(
            'gsap',
            'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js',
            array(),
            '3.12.5',
            true
        );
    }
}
add_action( 'wp_enqueue_scripts', 'gsapify_enqueue_gsap' );

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
