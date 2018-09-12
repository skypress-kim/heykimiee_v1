<?php
get_header();
try {
    if (! class_exists('SkyStache\\Init')) {
        throw new Exception('SkyStache failed to load');
    }
    global $wp;
    $sky_stache = new \SkyStache\Init;
    echo $sky_stache->render(add_query_arg(array(), $wp->request));
} catch (Exception $e) {
    echo "<h4>Error: {$e->getMessage()}</h4>";
}
get_footer();
