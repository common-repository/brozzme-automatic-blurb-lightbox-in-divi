<?php

/*
Plugin Name: Brozzme Automatic Blurb Lightbox in Divi
Plugin URI: https://brozzme.com/automatic-blurb-lightbox-module/
Description: Automatic lightbox image for blurb module.
Version: 1.0
Author: Benoti
Contributors: webstartup
Author URI: https://brozzme.com

*/

class brozzme_automatic_blurb_lightbox_divi{

    public function __construct()
    {
        $this->basename			 = plugin_basename( __FILE__ );
        $this->directory_path    = plugin_dir_path( __FILE__ );
        $this->directory_url	 = plugins_url( dirname( $this->basename ) );

        $this->plugin_text_domain = 'brozzme-automatic-lightbox-blurb';

        $this->_define_constants();

        add_action('add_meta_boxes', array($this, '_add_lightbox_enabler'));
        add_action( 'save_post', array($this, '_save_meta_box'), 10, 2 );
        
        $this->_init();

        add_action('admin_print_footer_scripts', array($this, 'metabox_display'));
        
    }

    /**
     * Define plugin constant
     */
    public function _define_constants(){
        defined('B7ELBD_TEXT_DOMAIN') or define('B7ELBD_TEXT_DOMAIN', $this->plugin_text_domain);
    }


    /**
     * Display action link in the plugins page
     * @param $links
     * @return array
     */
    public function _plugin_action_links($links) {

        $links[] = '<a href="https://brozzme.com" target="_blank">More plugins by Brozzme</a>';

        return $links;
    }

    /**
     *
     */
    public function _init() {

        load_plugin_textdomain( $this->plugin_text_domain, false, dirname( $this->basename ) . '/languages' );

        add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array( $this, '_plugin_action_links' ) );

        if(!is_admin()){
            include_once $this->directory_path . 'includes/brozzme_blurb_lightbox_front.php';
        }

        wp_enqueue_style('brozzme-lightbox-blurb', $this->directory_url .'/css/brozzme_automatic_lightbox_blurb.css');
    }

    /**
     * Add meta box
     * @param $post_type
     */
    public function _add_lightbox_enabler($post_type){

        $post_types = apply_filters('brozzme_automatic_blurb_lightbox', array('post', 'page', 'project') );

        if(in_array($post_type, $post_types)){
            add_meta_box( 'bbld_enable_box',
                __( 'Lightbox', $this->plugin_text_domain ),
                array($this, 'bbld_enable_callback'),
                $post_type,
                'side',
                'high'
            );
        }

    }

    /**
     * print js to display or hide metabox when using the page builder
     */
    public function metabox_display(){
        ?>
        <script>
            document.getElementById('et_pb_toggle_builder').addEventListener('click', function(e){
                if (e.originalTarget.className.split(' ')[3] === 'et_pb_builder_is_used') {
                    document.getElementById('bbld_enable_box').style.display = 'none';
                }
                else{
                    document.getElementById('bbld_enable_box').style.display = 'block';
                }

            }, false);
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Dom loaded');
                if( document.getElementById('et_pb_toggle_builder').classList.contains('et_pb_builder_is_used') ) {
                document.getElementById('bbld_enable_box').style.display = 'block';
                }
            });
        </script>
        <?php
    }
    /**
     * Render metabox
     * @param $post
     */
    public function bbld_enable_callback($post){
        $bbld_enable_meta = get_post_meta($post->ID, '_bbld_enable', true);

        ?>
        <input type="checkbox" name="bbld_enable" value="true" <?php checked($bbld_enable_meta, 'true');?>> <?php _e('Automatic lightbox for blurb module', $this->plugin_text_domain); ?>
        <?
        wp_nonce_field( 'bbld_enable_action', 'bbld_enable_nonce' );
    }

    /**
    * Save meta box content.
    *
    * @param int $post_id Post ID
    */
    public function _save_meta_box( $post_id ) {
        $nonce_name   = isset( $_POST['bbld_enable_nonce'] ) ? $_POST['bbld_enable_nonce'] : '';
        $nonce_action = 'bbld_enable_action';

       // Check if nonce is set.
        if ( ! isset( $nonce_name ) ) {
            return;
        }

        // Check if nonce is valid.
        if ( ! wp_verify_nonce( $nonce_name, $nonce_action ) ) {
            return;
        }

        // Check if user has permissions to save data.
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
        if($_POST['bbld_enable'] != ''){
            update_post_meta($post_id, '_bbld_enable', sanitize_text_field($_POST['bbld_enable']));
        }
        else{
            update_post_meta($post_id, '_bbld_enable', '');
        }
    }

}

new brozzme_automatic_blurb_lightbox_divi();