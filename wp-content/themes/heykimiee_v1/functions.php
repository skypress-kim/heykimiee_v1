<?php
/**
 * Enqueue Static Assets
 *
 * @method hk_enqueue_assets
 *
 * @return none
 */
function hk_enqueue_assets()
{
    // Styles
    wp_enqueue_style('bootstrap_css', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/css/bootstrap.min.css');
    wp_enqueue_style('lora_font', '//fonts.googleapis.com/css?family=Lora');
    wp_enqueue_style('swiper_css', '//cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/css/swiper.min.css');

    // Scripts
    // wp_register_script('testRoutes', get_stylesheet_directory_uri() . '/assets/js/test-routes.js', null, null, true);
    // wp_enqueue_script('testRoutes', 'testRoutes');
    wp_register_script('bootstrap_js', '//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.2/js/bootstrap.bundle.min.js', ['jquery'], null, true);
    wp_register_script('swiper_js', '//cdnjs.cloudflare.com/ajax/libs/Swiper/3.3.1/js/swiper.jquery.min.js', ['jquery'], null, true);
    wp_register_script('hk_swiper_js', get_stylesheet_directory_uri() . '/assets/js/script.min.js', ['swiper_js'], null, true);

    wp_enqueue_script('bootstrap_js', 'bootstrap_js');
    wp_enqueue_script('swiper_js', 'swiper_js');
    wp_enqueue_script('hk_swiper_js', 'hk_swiper_js');
}
add_action('wp_enqueue_scripts', 'hk_enqueue_assets');

/**
 * Template Map for SkyForge theme
 *
 * @method hk_template_map
 *
 * @param array $template_map
 *
 * @return array
 */
function hk_template_map(array $template_map) : array
{
    $map = [
    'page' => 'home'
  ];
    return $map;
}
add_filter('skyforge_template_map', 'hk_template_map');
