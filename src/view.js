/**
 * Frontend JavaScript for the GSAPify block
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOMContentLoaded');
    // Check if GSAP is loaded
    if (typeof gsap === 'undefined') {
        console.warn('GSAP is not loaded. Please check if the GSAPify block is properly configured.');
        return;
    }

    // Find all GSAPify blocks
    const blocks = document.querySelectorAll('.wp-block-create-block-gsapify');
    
    blocks.forEach(block => {
        // Each block's JavaScript will be handled by its own script tag
        // This file is mainly for any global GSAPify functionality
    });
}); 