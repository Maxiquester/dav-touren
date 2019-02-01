<?php
/*
Plugin Name:  DAV Touren
Plugin URI:   https://template.alpenverein.de/index.php/faq/touren/
Description:  Dieses Plugin erzeugt den CustomPostType "Touren". Damit lassen sich Touren in Wordpress verwalten und über ein entsprechendes Template ausgeben.
Version:      1.0.3
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

require_once 'add_posttype.php';
require_once 'add_taxonomy.php';
require_once 'add_acf-fields.php';
require_once 'customizer.php';


function checktoradio(){
    echo '<script type="text/javascript">jQuery("#tourcategorychecklist input, #tourtype-pop input, #tourtypechecklist input, #tourcondition-pop input, #tourconditionchecklist input, #tourtechnic-pop input, #tourtechnicchecklist input").each(function(){this.type="radio"});</script>';
}

add_action('admin_footer', 'checktoradio');
