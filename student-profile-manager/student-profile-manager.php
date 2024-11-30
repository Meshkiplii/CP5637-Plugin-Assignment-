<?php
/*
Plugin Name: Student Profile Manager
Description: A plugin to manage student profiles.
Version: 1.0
Author: Meshck Kiplimo
*/

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/student-profile-functions.php';
require_once plugin_dir_path(__FILE__) . 'includes/student-profile-admin.php';

// Activation hook
register_activation_hook(__FILE__, 'spm_activate');
function spm_activate() {
    // Create custom table for student profiles
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        phone varchar(20) DEFAULT '' NOT NULL,
        date_of_birth date DEFAULT '0000-00-00' NOT NULL,
        student_id varchar(20) DEFAULT '' NOT NULL,
        address text DEFAULT '' NOT NULL,
        course varchar(255) DEFAULT '' NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'spm_deactivate');
function spm_deactivate() {
    // Optionally, you can drop the table here
    global $wpdb;
    $table_name = $wpdb->prefix . 'student_profiles';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

// Enqueue styles
function spm_enqueue_styles() {
    wp_enqueue_style('student-profile-manager', plugins_url('css/student-profile-manager.css', __FILE__));
    wp_enqueue_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css');
}
add_action('admin_enqueue_scripts', 'spm_enqueue_styles');
add_action('wp_enqueue_scripts', 'spm_enqueue_styles');

// Enqueue scripts
function spm_enqueue_scripts($hook) {
    if ($hook != 'toplevel_page_student-profiles') {
        return;
    }
    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_script('student-profile-manager', plugins_url('js/student-profile-manager.js', __FILE__), array('jquery', 'jquery-ui-dialog'), null, true);
}
add_action('admin_enqueue_scripts', 'spm_enqueue_scripts');

// Add custom icon to the plugin
function spm_add_custom_plugin_icon($plugin_meta, $plugin_file) {
    if (plugin_basename(__FILE__) == $plugin_file) {
        $plugin_meta[] = '<img src="' . plugins_url('icon.png', __FILE__) . '" style="margin-right: 5px; vertical-align: middle;">';
    }
    return $plugin_meta;
}
add_filter('plugin_row_meta', 'spm_add_custom_plugin_icon', 10, 2);