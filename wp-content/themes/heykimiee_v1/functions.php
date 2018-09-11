<?php
function testScripts()
{
    wp_register_script('testRoutes', get_stylesheet_directory_uri() . '/assets/js/test-routes.js', null, null, true);
    wp_enqueue_script('testRoutes', 'testRoutes');
}
add_action('wp_enqueue_scripts', 'testScripts');
