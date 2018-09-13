<?php
function testScripts()
{
    wp_register_script('testRoutes', get_stylesheet_directory_uri() . '/assets/js/test-routes.js', null, null, true);
    wp_enqueue_script('testRoutes', 'testRoutes');
}
add_action('wp_enqueue_scripts', 'testScripts');

function getTemplate(string $template)
{
    $template_path = __DIR__ . "/templates/$template.html";
    if (! file_exists($template_path)) {
        return "<h4>Error Missing Template $template</h4>";
    }
    return file_get_contents($template_path);
}