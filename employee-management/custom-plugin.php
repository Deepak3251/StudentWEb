<?php
/*
 * Plugin Name: Employee Management System
 * Description: This is a CRUD Employee Management System 
 * Plugin URI: https://example.com/custom-plugin
 * Author: Sample User
 * Auther URI: https://example.com
 * Version: 1.0
 * Requires at least: 6.3.2
 * Requires PHP: 7.4
*/

// adding path or url or css and javascript 

define("EMS_PLUGIN_URL",plugin_dir_url(__FILE__));
define("EMS_PLUGIN_PATH", plugin_dir_path(__FILE__));


//add action hook admin menu

add_action("admin_menu","cp_add_admin_menu");// add action is a wordpress function and admin menu is a action hook 


// add function

function cp_add_admin_menu(){
    // add menu page 

    add_menu_page("Employee System | Employee Management System ","Employee System ","manage_options","employee-system","ems_curd_system","dashicons-admin-home",23);

    // add submenu page 
    add_submenu_page("employee-system","Add Employee","Add Employee","manage_options","employee-system","ems_curd_system");

    add_submenu_page("employee-system","List Employee","List Employee","manage_options","list-employee","ems_list_employee");

}

//Menu handle Callback
function ems_curd_system(){
    include_once(EMS_PLUGIN_PATH."/pages/add-employee.php");

}

function ems_list_employee(){
    include_once(EMS_PLUGIN_PATH."/pages/list-employee.php");
}


register_activation_hook(__FILE__,"ems_create_table");

function ems_create_table(){
    global $wpdb;

    $table_prefix = $wpdb->prefix;

   $sql="
    CREATE TABLE {$table_prefix}ems_form_data (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `phoneNo` varchar(50) DEFAULT NULL,
  `gender` enum('male','female','other') DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
 ";

 include_once ABSPATH."wp-admin/includes/upgrade.php";
 dbDelta($sql);



}

register_deactivation_hook(__FILE__,"ems_drop_table");

function ems_drop_table(){
    global $wpdb;

    $table_prefix=$wpdb->prefix;

    $sql="DROP TABLE IF EXISTS {$table_prefix}ems_from_data";
    $wpdb->query($sql);

}

add_action("admin_enqueue_scripts","ems_add_plugin_assets");


function ems_add_plugin_assets(){
    //style(css)

    wp_enqueue_style("ems-bootstrap-css",EMS_PLUGIN_URL."css/bootstrap.min.css",array(),"1.0.0","all");
    wp_enqueue_style("ems-datatable-css",EMS_PLUGIN_URL."css/dataTables.dataTables.data.min.css",array(),"1.0.0","all");


    //js 
    wp_enqueue_script("ems-bootstaps-js", EMS_PLUGIN_URL."js/bootstrap.min.js",array("jquery"),"1.0.0");
    wp_enqueue_script("ems-custom-js", EMS_PLUGIN_URL."js/custom.js",array("jquery"),"1.0.0");

}






