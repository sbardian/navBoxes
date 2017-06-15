<?php
/**
 * Created by PhpStorm.
 * User: sbardian
 * Date: 6/14/17
 * Time: 6:45 PM
 */


/*
Plugin Name: navBoxes
Description: Navigation boxes.
Version: 0.1.0
Author: Brian Andrews
*/
?>

<?php

/**
 * Create our class.
 *
 */
if ( !class_exists('navBoxes' ) ) {
  class navBoxes
  {
    /**
     * Init function.
     *
     */
    function init()
    {
      function navBoxes_activation()
      {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();
        $db = $wpdb->prefix . "navBoxesTable";
        // create the navBoxes database table
        if ($wpdb->get_var("show tables like '$db'") != $db) {
          $sql = "CREATE TABLE  $db  (
		        id mediumint(9) NOT NULL AUTO_INCREMENT,
		        caption TEXT NOT NULL,
		        fontawsome TEXT NOT NULL,
		        UNIQUE KEY id (id)
		      ) $charset_collate;";

          require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
          dbDelta($sql);
        }
      }
      register_activation_hook(__FILE__, 'navBoxes_activation');

      /**
       * Remove our database table on deactivation for storing navBoxes.
       *
       */
      // TODO: move this to uninstall instead of deactivation. . .
      function navBoxes_deactivation()
      {
        global $wpdb;
        $db = $wpdb->prefix . "navBoxesTable";

        if ($wpdb->get_var("show tables like '$db'") == $db) {
          $sql = "DROP TABLE IF EXISTS $db";
          $wpdb->query($sql);
        }
      }
      register_deactivation_hook(__FILE__, 'navBoxes_deactivation');

      /**
       * Add our style sheets.
       *
       */
      function navBoxes_styles()
      {
        // Register the style like this for a plugin:
        wp_register_style('nav-styles', plugins_url('/public/css/nav-styles.css', __FILE__), array(), '1', 'all');

        // For either a plugin or a theme, you can then enqueue the style:
        wp_enqueue_style('nav-styles');
      }
      add_action('wp_enqueue_scripts', 'navBoxes_styles');


      /**
       * Add our scripts.
       *
       */
      /*
      function navBoxes_scripts()
      {
        wp_register_script('bootstrap', plugins_url('/public/js/bootstrap.min.js', __FILE__));
        wp_enqueue_script('bootstrap');
      }
      add_action('wp_enqueue_scripts', 'navBoxes_scripts');
      */

      /**
       * Add our Settings menu to Admin
       *
       *
       *
       */
      // TODO : add our backend.
      //require 'admin/options.php';

      /**
       * Add our shortcode
       *
       */
      function navBoxes_shortcodes_init()
      {
        function navBoxes_shortcode($atts = [], $content = null)
        {
          $load = 'public/navs.php';

          ob_start();
          include $load;
          $content = ob_get_contents();
          ob_end_clean();
          return $content;
        }
        add_shortcode('navBoxes', 'navBoxes_shortcode');
      }
      add_action('init', 'navBoxes_shortcodes_init');

    }

  }

  /**
   * Call our class.
   *
   */
  navBoxes::init();
}

?>