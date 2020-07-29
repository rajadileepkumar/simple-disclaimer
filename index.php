<?php

/**
 * Plugin Name: Simple Disclaimer
 * Plugin URI: https://www.github.com/rajadileepkumar
 * Description: Simple Disclaimer
 * Version: 0.1
 * Author: Raja Dileep Kumar
 * Author URI: https://github.com/rajadileepkumar
 * License: GPL2
 */

if (!class_exists('Simple_Disclaimer')) {
    class Simple_Disclaimer
    {
        public function  __construct()
        {
            /**
             * Hooks for menus and scripts
             */
            add_action('admin_menu', array($this, 'disclaimer_setting_page'));
            add_action('wp_footer', array($this, 'disclaimer_load_in_footer'));
            add_action('init', array($this, 'disclaimer_load_styles'));
        }
        /**
         * Load style and scripts
         */
        public function disclaimer_load_styles()
        {
            wp_enqueue_style('style-css', plugin_dir_url(__FILE__) . 'admin/css/style.css');
            wp_enqueue_script('jquery');
            wp_enqueue_script('grt-cookie-consent-js', plugin_dir_url(__FILE__) . 'admin/js/grt-cookie-consent.js', array(), false, true);
            wp_enqueue_script('script-js', plugin_dir_url(__FILE__) . 'admin/js/script.js', array(), false, true);
        }
        /**
         * add page to under settings menu
         */
        public function disclaimer_setting_page()
        {
            add_options_page(__('Disclaimer', 'plugindomain'), __('Disclaimer', 'plugindomain'), 'manage_options', 'disclaimer_option_page', array($this, 'disclaimer_option_page_callback'));
        }

        /**
         * Content and Details of disclaimer page
         */
        public function disclaimer_option_page_callback()
        {
?>
            <div class="wrap">
                <h2>Disclaimer Page</h2>
                <form action="options.php" method="post">
                    <?php wp_nonce_field('update-options'); ?>
                    <p>
                        <label>Disclaimer Content</label><br>
                        <textarea cols="50" rows="10" name="disclaimerContent" id="disclaimerContent" style="vertical-align: middle"><?php echo esc_textarea(get_option('disclaimerContent')) ?></textarea>
                    </p>
                    <p>

                        <input type="checkbox" name="disclaimerPosts" id="disclaimerPosts" value="<?php echo get_option('disclaimerPosts'); ?>" <?php echo get_option('disclaimerPosts') === '1' ? 'checked' : '' ?>>
                        <label>Posts</label>
                    </p>
                    <p>
                        <input type="checkbox" name="disclaimerPages" id="disclaimerPages" value="<?php echo get_option('disclaimerPages'); ?>" <?php echo get_option('disclaimerPages') === '1' ? 'checked' : '' ?>>
                        <label>Pages</label>
                    </p>
                    <p>
                        <input type="submit" value="Save" class="button button-primary">
                    </p>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="page_options" value="disclaimerContent,disclaimerPosts,disclaimerPages">
                </form>
            </div>
            <?php
        }
        /**
         * Trigger the popup on footer
         */
        public function disclaimer_load_in_footer()
        {
            $pages = get_option('disclaimerPages');
            $posts = get_option('disclaimerPosts');
            if ($pages === '1' || $posts === '1') {
            ?>
                <div class="disclaimer-content grt-cookie">
                    <div class="disclaimer-body grt-cookies-msg">
                        <p><?php echo esc_textarea(get_option('disclaimerContent')) ?></p>
                        <div class="disclaimer-action-bts">
                            <button class="grt-cookie-button">Accept</button>
                            <button class="btn-close">Close</button>
                        </div>
                    </div>
                </div>
            <?php
            }
        }
    }
}
$obj = new Simple_Disclaimer();
?>