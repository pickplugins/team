<?php
if ( ! defined('ABSPATH')) exit;  // if direct access 

if( ! class_exists( 'settings_tabs_reviews' ) ) {
    class settings_tabs_reviews{

        public  $title = 'Hope you enjoy our plugin';
        public  $option = 'option_name';
        public  $review_link = '';
        public  $support_link = '';
        public  $documentation_link = '';
        public  $tutorials_link = '';


        public function __construct($args){

            $this->title = isset($args['title']) ? $args['title'] : '';
            $this->option = isset($args['option']) ? $args['option'] : '';
            $this->review_link = isset($args['review_link']) ? $args['review_link'] : '';
            $this->support_link = isset($args['support_link']) ? $args['support_link'] : '';
            $this->documentation_link = isset($args['documentation_link']) ? $args['documentation_link'] : '';
            $this->tutorials_link = isset($args['tutorials_link']) ? $args['tutorials_link'] : '';




            add_action('admin_footer', array($this, 'display_popup'));
            add_action('admin_notices', array( $this, 'review_action_notice' ));

        }

        function review_action_notice(){

            if(!current_user_can('manage_options')) return;

            $nonce = isset($_GET['_wpnonce']) ? sanitize_text_field($_GET['_wpnonce']) : '';

            if(wp_verify_nonce( $nonce, $this->option.'_review_notice' ) ) {
                $review_status = isset($_GET['review_status']) ? sanitize_text_field($_GET['review_status']) : '';
                $option = get_option($this->option);

                $gmt_offset = get_option('gmt_offset');
                $current_date = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));

                if($review_status =='remind_later'):

                    $option['review_status'] = 'remind_later';
                    $option['remind_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));

                    ?>
                    <div class="update-nag is-dismissible">We will remind you later.</div>
                    <?php
                    update_option($this->option, $option);

                elseif ($review_status =='done'):

                    $option['review_status'] = 'done';
                    ?>
                    <div class="update-nag notice is-dismissible">Thanks for your time and feedback.</div>
                    <?php

                    update_option($this->option, $option);

                endif;


            }



        }


        function display_popup(){

            if(!current_user_can('manage_options')) return;

            wp_enqueue_style('font-awesome-5');

            $option = get_option($this->option);
            $review_status = isset($option['review_status']) ? $option['review_status'] : '';
            $remind_date = isset($option['remind_date']) ? $option['remind_date'] : '';

            $admin_url = get_admin_url();
            //$admin_url = str_replace( '%7E', '~', $_SERVER['REQUEST_URI']);


            $gmt_offset = get_option('gmt_offset');
            $today_date = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));


//            error_log($review_status);
//            error_log($remind_date);



            if(!empty($review_status)){
                if($review_status == 'done'){ return;}
                if($review_status == 'remind_later' && (strtotime($today_date) < strtotime($remind_date)) ){ return;}

            }else{
                $option['review_status'] = 'remind_later';
                $option['remind_date'] = date('Y-m-d H:i:s', strtotime('+7 days'));
                update_option($this->option, $option);

                return;
            }

            ?>
            <div class="settings-tabs-reviews">
                <div class="actions">
                    <span title="To permanently hide please click on Already did." class="hide"><i class="fas fa-times"></i></span>
                </div>
                <div class="title"> <?php echo $this->title; ?></div>
                <div class="content">
                    <p class="">We wish your 2 minutes to write your feedback about our plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

                    <a target="_blank" href="<?php echo $this->review_link; ?>" class="button"><i class="fab fa-wordpress"></i> Write a review</a>
                    <a href="<?php echo wp_nonce_url($admin_url.'?review_status=done', $this->option.'_review_notice', '_wpnonce'); ?>" class="button"><i class="far fa-thumbs-up"></i> Already did</a>
                    <a  href="<?php echo wp_nonce_url($admin_url.'?review_status=remind_later', $this->option.'_review_notice', '_wpnonce'); ?>" class="button"><i class="far fa-bell"></i> Remind me later</a>

                    <p>Do you have any issue, please contact our support team by creating a support ticket or please watch tutorials and documentation.</p>
                    <a target="_blank" href="<?php echo $this->support_link; ?>" class="button"><i class="far fa-question-circle"></i> Create support ticket</a>
                    <a target="_blank" href="<?php echo $this->documentation_link; ?>" class="button"><i class="far fa-file-code"></i> Documentation</a>
                    <a target="_blank" href="<?php echo $this->tutorials_link; ?>" class="button"><i class="fab fa-youtube"></i> Tutorials</a>
                </div>


            </div>

            <script>
                jQuery(document).ready(function($){
                    $(document).on('click', ".settings-tabs-reviews .hide", function() {
                        $(this).parent().parent().fadeOut();
                    })
                })
            </script>

            <style type="text/css">
                .settings-tabs-reviews{
                    position: fixed;
                    right: 15px;
                    bottom: 15px;
                    width: 500px;
                    background: #fff;
                    padding: 0px;
                    box-shadow: 0 0 6px 3px rgba(183, 183, 183, 0.4);
                    z-index: 9999;
                    border: 1px solid #3f51b5;
                }

                .settings-tabs-reviews p{
                    font-size: 15px;
                }

                .settings-tabs-reviews .hide{
                    color: #fff;
                    padding: 2px 8px;
                    background: #e21d1d;
                    margin: 7px 4px;
                    display: inline-block;
                    cursor: pointer;
                }

                .settings-tabs-reviews .title{
                    font-size: 17px;
                    border-bottom: 1px solid #ddd;
                    padding: 10px;
                    background: #3F51B5;
                    color: #fff;
                }

                .settings-tabs-reviews .content{
                    padding: 10px;
                }

                .settings-tabs-reviews .actions{
                    position: absolute;
                    top: 0;
                    right: 0;
                }

                @media only screen and ( min-width: 0px ) and ( max-width: 767px ){
                    .settings-tabs-reviews{
                        width: 100%;
                        right: 0;
                        bottom: 0;
                    }
                }


            </style>
            <?php

        }

    }


}

