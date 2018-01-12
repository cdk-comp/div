<?php

/**
 *
 * Cleaners and optimizations features
 *
 * @since  1.0
 *
 */

add_action('wp_head', function () {
    wp_deregister_script('sitepress');
});

add_action('wp_footer', function () {
    wp_deregister_script('wp-embed');
});

add_action('widgets_init', function () {
    global $wp_widget_factory;
    remove_action(
        'wp_head',
        array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style')
    );
});

if (is_admin()) {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_head', 'icl_lang_sel_nav_css', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
}

/**
 * Disable WP and Plugins Features
 */
add_action('init', function () {

    if (is_admin()) return;

    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');

    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'index_rel_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'feed_links_extra', 3);
    remove_action('wp_head', 'feed_links', 2);
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    remove_action('set_comment_cookies', 'wp_set_comment_cookies');

    // WPML clean
    define('ICL_DONT_LOAD_LANGUAGE_SELECTOR_CSS', true);
    define('ICL_DONT_LOAD_NAVIGATION_CSS', true);
    define('ICL_DONT_LOAD_LANGUAGES_JS', true);

    // CF7 clean
    add_filter( 'wpcf7_load_css', '__return_false' );

});


/**
 * Remove <meta name="generator"> tag created by the WPML PLugin.
 * Wrapped in an if-statement that checks for an instance of the
 * sitepress-class (made global by WPML)
 *
 * @url http://wordpress.stackexchange.com/questions/117469/how-to-remove-wpml-generator-meta-tag-by-themes-functions-php-override-plugin
 *
 * @uses add_action
 * @uses remove_action
 * @uses current_filter
 */
if ( !empty ( $GLOBALS['sitepress'] ) ) {

    function remove_wpml_generator() {

        remove_action(
            current_filter(),
            array ( $GLOBALS['sitepress'], 'meta_generator_tag' )
        );

    }
    add_action( 'wp_head', 'remove_wpml_generator', 0 );

}


/**
 * Security features
 *
 */
if (!is_admin()) {
    add_filter('xmlrpc_enabled', '__return_false');
    add_filter('json_enabled', '__return_false');
    add_filter('json_jsonp_enabled', '__return_false');
//    add_filter('rest_enabled', '__return_false');
//    add_filter('rest_jsonp_enabled', '__return_false');
//    add_filter('rest_authentication_errors', 'throw_rest_auth_error');
    remove_action('wp_head', 'rsd_link');
    remove_action('xmlrpc_rsd_apis', 'rest_output_rsd');
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
    remove_action('template_redirect', 'rest_output_link_header', 11);
}

if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
    wp_die();
}
if (defined('REST_REQUEST') && REST_REQUEST) {
    wp_die();
}
function throw_rest_auth_error($access)
{
    return new WP_Error('api_disabled', 'The REST API is disabled.', ['status' => 404]);
}

/**
 * Disable reset password
 *
 */
class Password_Reset_Removed
{

    function __construct()
    {
        add_filter('show_password_fields', array($this, 'disable'));
        add_filter('allow_password_reset', array($this, 'disable'));
        add_filter('gettext', array($this, 'remove'));
    }

    function disable()
    {
        if (is_admin()) {
            $userdata = wp_get_current_user();
            $user = new WP_User($userdata->ID);
            if (!empty($user->roles) && is_array($user->roles) && $user->roles[0] == 'administrator')
                return true;
        }
        return false;
    }

    function remove($text)
    {
        return str_replace(array('Lost your password?', 'Lost your password', 'Mot de passe oubliÃ©', 'Mot de passe oubliÃ©?', '×©×—×–×•×¨ ×¡×™×¡×ž×”?', '×©×—×–×•×¨ ×¡×™×¡×ž×”'), '', trim($text, '?'));
    }
}

$pass_reset_removed = new Password_Reset_Removed();


/**
 * Remove query string from static files
 *
 * @param $src
 * @return string
 */
function remove_cssjs_ver($src)
{
    if (strpos($src, '?ver='))
        $src = remove_query_arg('ver', $src);

    return $src;
}

add_filter('style_loader_src', 'remove_cssjs_ver', 10, 2);
add_filter('script_loader_src', 'remove_cssjs_ver', 10, 2);
