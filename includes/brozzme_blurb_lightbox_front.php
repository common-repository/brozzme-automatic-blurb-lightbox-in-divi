<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 28/04/2017
 * Time: 00:17
 */
class brozzme_blurb_lightbox_front
{

    public function __construct()
    {
        add_filter('the_content', array($this, 'add_lightbox_class'), 99);
    }

    public function add_lightbox_class($content){
        global $post;

        $is_enable = get_post_meta($post->ID, '_bbld_enable', true);
        $is_enable_bypass = apply_filters('brozzme_blurb_lightbox_bypass', false);

        if($is_enable == 'true' || $is_enable_bypass == true){

            $getLink = '/et_pb_main_blurb_image">([^\d|\w].+)(><img)/';

            if (preg_match_all($getLink, $content, $m, PREG_PATTERN_ORDER)):
                
                foreach ($m[0] as $ht) {
                    $content = preg_replace($getLink, 'et_pb_main_blurb_image">$1 class="et_pb_lightbox_image" $2', $content);
                }
            endif;

        }
        return $content;
    }

}

new brozzme_blurb_lightbox_front();