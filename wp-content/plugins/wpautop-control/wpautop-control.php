<?php
/*
Plugin Name: wpautop-control
Plugin URI: http://blog.bigsmoke.us/tag/wpautop-control/
Description: This plugin allows you fine control of when and when not to enable the wpautop filter on posts.
Author: Rowan Rodrik van der Molen
Author URI: http://blog.bigsmoke.us/
Version: 1.0
*/

if ( is_admin() ) {
  add_action('admin_menu', 'wpautop_control_menu');
  add_action('admin_init', 'wpautop_control_settings');

  function wpautop_control_menu() {
    add_submenu_page('options-general.php', 'wpautop-control', 'wpautop control', 'manage_options', 'wpautop-control-menu', 'wpautop_control_options');
  }

  function wpautop_control_options() {
    if (!current_user_can('manage_options'))  {
      wp_die( __('You do not have sufficient permissions to access this page.') );
    }

  ?>
  <div class="wrap">
    <h2>wpautop control options</h2>

    <form method="post" action="options.php">
      <?php settings_fields('wpautop-control') ?>

      <p>Normally, WordPress filters your posts' content using the wpautop filter. Roughly, what this filter does is that it replaces newlines and empty lines with <tt>&lt;br /&gt;</tt> or <tt>&lt;p&gt;</tt>. The setting below lets you turn this filter on or off. (You can later override it on a post-by-post basis by setting the wpautop custom field to ‘true’ or ‘false’.)</p>

      <table class="form-table">
        <tr valign="top">
          <th scope="row">wpautop filter on by default?</th>
          <td>
            <label><input type="radio" name="wpautop_on_by_default" value="1" <?php if ( get_option('wpautop_on_by_default') == '1' ) echo 'checked="1"' ?>> yes <small>(WordPress' default behaviour)</small></label><br />
            <label><input type="radio" name="wpautop_on_by_default" value="0" <?php if ( get_option('wpautop_on_by_default') == '0' ) echo 'checked="1"' ?>> no <small>(turn of WordPress' auto-formatting, except for selected posts)</small></label>
          </td>
      </table>

      <p class="submit">
      <input type="submit" class="button-primary" value="Save Changes" />
      </p>
    </form>
  </div>
  <?php
  }

  function wpautop_control_settings() {
    register_setting('wpautop-control', 'wpautop_on_by_default', 'intval');
  }
}
else { // ! is_admin()
  add_filter('the_content', 'wpautop_control_filter', 9);

  function wpautop_control_filter($content) {
    global $post;

    // Get the keys and values of the custom fields:
    $post_wpautop_value = get_post_meta($post->ID, 'wpautop', true);

    $default_wpautop_value = intval( get_option('wpautop_on_by_default', '1') );

    $remove_filter = false;
    if ( empty($post_wpautop_value) )
      $remove_filter = ! $default_wpautop_value;
    elseif ( in_array($post_wpautop_value, array('true', 'on', 'yes')) )
      $remove_filter = false;
    elseif ( in_array($post_wpautop_value, array('false', 'off', 'no')) )
      $remove_filter = true;

    if ( $remove_filter ) {
      remove_filter('the_content', 'wpautop');
      remove_filter('the_excerpt', 'wpautop');
    }

    return $content;
  }
}

?>
