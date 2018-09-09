<?php
/**
 * Created by PhpStorm.
 * User: sbardian
 * Date: 6/16/17
 * Time: 10:30 PM
 */
?>

<?php

/**
 * Set some default options for our navBoxes Settings.
 *
 */
$default_options = array(
    'title' => 'Fake Title',
    'titleBgColor' => '#9dbb3f'
);
add_option('navBoxes-Settings', $default_options);

/**
 * Register our settings.
 */
function navBoxes_register_settings() {
  register_setting('navBoxes-Settings', 'navBoxes-Settings');
}
add_action( 'admin_init', 'navBoxes_register_settings' );

/**
 * Add our menu and submenu to the Admin Dashboard.
 */
add_action('admin_menu', 'navBoxesMenu');

function navBoxesMenu()
{
  add_menu_page(
      'Edit NavBoxes',
      'NavBoxes',
      'manage_options',
      'navBoxes',
      null,
      null,
      null
  );
  add_submenu_page(
      'navBoxes',
      'navBoxes Settings',
      'Settings',
      'manage_options',
      'navBoxesSettings',
      'navBoxes_RenderSettings'
  );
}

/**
 * Render our settings page.
 *
 */
function NavBoxes_RenderSettings() { ?>
  <h1> NavBoxes Settings</h1>
  <?php $options = get_option('navBoxes-Settings'); ?>
  <form method="post" action="options.php">
    <?php
    settings_fields('navBoxes-Settings');
    do_settings_sections( 'navBoxes-Settings');
    ?>
    <table class="form-table">
      <tr valign="top">
        <th scope="row">Title:</th>
        <td>
          <span style="font-size: 6pt; color: red">Leave blank for none</span>
          <input type="text" name="navBoxes-Settings[title]" value="<?php echo $options['title']; ?>"/>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Title Background Color:</th>
        <td>
          <span style="font-size: 6pt; color: red">Enter HEX web color including #</span>
          <input type="text" name="navBoxes-Settings[titleBgColor]" value="<?php echo $options['titleBgColor']; ?>"/>
        </td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>
  <?php
}
?>