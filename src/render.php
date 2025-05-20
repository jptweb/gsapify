<?php
/**
 * Server-side rendering of the `create-block/gsapify` block.
 *
 * @package create-block
 */

/**
 * Renders the `create-block/gsapify` block on the server.
 *
 * @param array    $attributes Block attributes.
 * @param string   $content    Block default content.
 * @param WP_Block $block      Block instance.
 * @return string Returns the post content with the GSAP animation block.
 */
function render_block_gsapify( $attributes, $content, $block ) {
    // Get our custom attributes
    $custom_html = isset( $attributes['customHtml'] ) ? $attributes['customHtml'] : '';
    $custom_css = isset( $attributes['customCss'] ) ? $attributes['customCss'] : '';
    $custom_js = isset( $attributes['customJs'] ) ? $attributes['customJs'] : '';

    // Start building our output
    $wrapper_attributes = get_block_wrapper_attributes();
    
    // Create a unique ID for this instance of the block
    $block_id = 'gsapify-' . uniqid();
    
    // Build the output
    $output = sprintf(
        '<div %s>',
        $wrapper_attributes
    );
    
    // Add the container with our unique ID
    $output .= sprintf(
        '<div class="gsapify-container" id="%s">',
        esc_attr( $block_id )
    );
    
    // Add the HTML content
    $output .=  $custom_html ;
    
    // Add the CSS
    if ( ! empty( $custom_css ) ) {
        $output .= sprintf(
            '<style>%s</style>',
            $custom_css
        );
    }
    
    // Add the JavaScript
    if ( ! empty( $custom_js ) ) {
        $output .= sprintf(
            '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    if (typeof gsap !== "undefined") {
                        %s
                    } else {
                        console.warn("GSAP is not loaded. Please check if the GSAPify block is properly configured.");
                    }
                });
            </script>',
            $custom_js
        );
    }
    
    $output .= '</div></div>';
    
    return $output;
} 