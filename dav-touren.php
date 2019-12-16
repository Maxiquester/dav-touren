<?php
/*
Plugin Name:  DAV Touren
Plugin URI:   https://template.alpenverein.de/index.php/faq/touren/
Description:  Dieses Plugin erzeugt den CustomPostType "Touren". Damit lassen sich Touren in Wordpress verwalten und über ein entsprechendes Template ausgeben.
Version:      1.1.0
Author:       Deutscher Alpenverein
Author URI:   https://template.alpenverein.de/
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
*/

require 'update/plugin-update-checker.php';
$MyUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
    'https://template.alpenverein.de/updates/?action=get_metadata&slug=dav-touren', //Metadata URL.
    __FILE__, //Full path to the main plugin file.
    'dav-touren' //Plugin slug. Usually it's the same as the name of the directory.
);

require_once 'includes/add_posttype.php';
require_once 'includes/add_taxonomy.php';
require_once 'includes/add_acf-fields.php';
require_once 'includes/add_shortcodes.php';
require_once 'includes/customizer.php';
require_once 'includes/querybuilder.php';



add_action('admin_footer', 'checktoradio');


/**
 * change the form in the classic editor from checkboxes to radioinput
 *
 */
function checktoradio(){
    echo '<script type="text/javascript">jQuery("#tourcategorychecklist input, #tourtype-pop input, #tourtypechecklist input, #tourcondition-pop input, #tourconditionchecklist input, #tourtechnic-pop input, #tourtechnicchecklist input").each(function(){this.type="radio"});</script>';
}




function getCurrentURI() {

    $return = '';

    $return = $_SERVER['PATH_INFO'];

    $url = wp_parse_url( $_SERVER['REQUEST_URI']);

    $url_delete = '/page\/\d\//';
    $url_n = preg_replace($url_delete,'',$url['path']);

    if($_SERVER['QUERY_STRING'] != '') {

        $return .= get_site_url().$url_n.'?'.$_SERVER['QUERY_STRING'].'&';

    } else {$return .= get_site_url().$url_n.'?';}

    return $return;
}


/**
 * Activation hook to register a new Role and assign it persona capabilities
 */
function touren_plugin_activation() {

    // Define our custom capabilities
    $tourenCaps = array(
        'edit_tourdata'             => true,
        'delete_tourdata'             => true,
        'assign_tourdata'             => true,
        'edit_others_touren'        => true,
        'delete_others_touren'      => true,
        'delete_private_touren'     => true,
        'edit_private_touren'       => true,
        'read_private_touren'         => true,
        'edit_published_touren'       => true,
        'publish_touren'          => true,
        'delete_published_touren'     => true,
        'edit_touren'             => true,
        'delete_touren'           => true,
        'edit_tour'              => true,
        'read_tour'              => true,
        'delete_tour'            => true,
        'read'                  => true,

    );

    add_role( 'touren', __('Touren'), $tourenCaps );

    // Add custom capabilities to Admin and Editor Roles
    $roles = array( 'administrator', 'editor');
    foreach ( $roles as $roleName ) {
        // Get role
        $role = get_role( $roleName );

        // Check role exists
        if ( is_null( $role) ) {
            continue;
        }

        // Iterate through our custom capabilities, adding them
        // to this role if they are enabled
        foreach ( $tourenCaps as $capability => $enabled ) {
            if ( $enabled ) {
                // Add capability
                $role->add_cap( $capability );
            }
        }
    }

    unset( $role );

}


register_activation_hook( __FILE__, 'touren_plugin_activation');


