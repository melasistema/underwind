/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

;(function ($) {
    console.log('--- Customizer script IS running ---')
    // Site title and description.
    wp.customize('blogname', function (value) {
        value.bind(function (to) {
            $('.site-title a').text(to)
        })
    })
    wp.customize('blogdescription', function (value) {
        value.bind(function (to) {
            $('.site-description').text(to)
        })
    })

    // Header text color.
    wp.customize('header_textcolor', function (value) {
        console.log('--- Customizer header color ---')
        value.bind(function (to) {
            if ('blank' === to) {
                $('.site-title, .site-description').css({
                    clip: 'rect(1px, 1px, 1px, 1px)',
                    position: 'absolute',
                })
            } else {
                $('.site-title, .site-description').css({
                    clip: 'auto',
                    position: 'relative',
                })
                $('.site-title a, .site-description').css({
                    color: to,
                })
            }
        })
    })

    // Display site title and tagline.
    wp.customize('display_header_text', function (value) {
        console.log('Customizing display_header_text')

        var setVisibility = function (value) {
            if (value === true || value === '1') {
                $('.site-branding-text-wrap').removeClass('is-hidden-branding')
            } else {
                $('.site-branding-text-wrap').addClass('is-hidden-branding')
            }
        }

        // Initial state
        setVisibility(value.get())

        // Live update
        value.bind(setVisibility)
    })
})(jQuery)
