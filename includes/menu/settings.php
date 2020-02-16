<?php	
if ( ! defined('ABSPATH')) exit;  // if direct access


$current_tab = isset($_POST['tab']) ? $_POST['tab'] : 'general';

$team_settings_tab = array();

$team_settings_tab[] = array(
    'id' => 'general',
    'title' => sprintf(__('%s General','team'),'<i class="fas fa-list-ul"></i>'),
    'priority' => 1,
    'active' => ($current_tab == 'general') ? true : false,
);

$team_settings_tab[] = array(
    'id' => 'team_member',
    'title' => sprintf(__('%s Team member','team'),'<i class="fas fa-user-tag"></i>'),
    'priority' => 2,
    'active' => ($current_tab == 'team_member') ? true : false,
);


$team_settings_tab[] = array(
    'id' => 'help_support',
    'title' => sprintf(__('%s Help & support','team'),'<i class="fas fa-hands-helping"></i>'),
    'priority' => 3,
    'active' => ($current_tab == 'help_support') ? true : false,
);



$team_settings_tab = apply_filters('team_settings_tabs', $team_settings_tab);

$tabs_sorted = array();

if(!empty($team_settings_tab))
foreach ($team_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset( $tab['priority'] ) ? $tab['priority'] : 0;
array_multisort($tabs_sorted, SORT_ASC, $team_settings_tab);


wp_enqueue_script('jquery');
wp_enqueue_script('jquery-ui-sortable');
wp_enqueue_script( 'jquery-ui-core' );
wp_enqueue_script('jquery-ui-accordion');
wp_enqueue_style( 'wp-color-picker' );
wp_enqueue_script('wp-color-picker');
wp_enqueue_style('font-awesome-5');
wp_enqueue_style('settings-tabs');
wp_enqueue_script('settings-tabs');


$review_status = isset($_GET['review_status']) ? sanitize_text_field($_GET['review_status']) : '';
$team_info = get_option('team_info');
$team_settings = get_option('team_settings');

?>
<div class="wrap">
	<div id="icon-tools" class="icon32"><br></div><h2><?php echo sprintf(__('%s Settings', 'team'), team_plugin_name)?></h2>


    <?php
    $gmt_offset = get_option('gmt_offset');
    $current_date = date('Y-m-d H:i:s', strtotime('+'.$gmt_offset.' hour'));
    //echo '<pre>'.var_export($current_date, true).'</pre>';


    if($review_status =='remind_later'):

        $team_info['review_status'] = 'remind_later';
        $team_info['remind_date'] = date('Y-m-d H:i:s', strtotime('+30 days'));


        ?>
        <div class="update-nag is-dismissible">We will remind you later.</div>
        <?php
        update_option('team_info', $team_info);

    elseif ($review_status =='done'):

        $team_info['review_status'] = 'done';
        ?>
        <div class="update-nag notice is-dismissible">Thanks for your time and feedback.</div>
        <?php

        update_option('team_info', $team_info);

    endif;

    ?>



		<form  method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
	        <input type="hidden" name="team_hidden" value="Y">
            <input type="hidden" name="tab" value="<?php echo $current_tab; ?>">

            <?php
            if(!empty($_POST['team_hidden'])){

                $nonce = sanitize_text_field($_POST['_wpnonce']);

                if(wp_verify_nonce( $nonce, 'team_nonce' ) && $_POST['team_hidden'] == 'Y') {

                    do_action('team_settings_save');

                    ?>
                    <div class="updated notice  is-dismissible"><p><strong><?php _e('Changes Saved.', 'team' ); ?></strong></p></div>

                    <?php
                }
            }
            ?>

            <div class="settings-tabs-loading" style="">Loading...</div>
            <div class="settings-tabs vertical has-right-panel" style="display: none">


                <div class="settings-tabs-right-panel">
                    <?php
                    if(!empty($team_settings_tab))
                    foreach ($team_settings_tab as $tab) {
                        $id = $tab['id'];
                        $active = $tab['active'];

                        ?>
                        <div class="right-panel-content <?php if($active) echo 'active';?> right-panel-content-<?php echo $id; ?>">
                            <?php

                            do_action('team_settings_tabs_right_panel_'.$id);
                            ?>

                        </div>
                        <?php

                    }
                    ?>
                </div>

                <ul class="tab-navs">
                    <?php
                    if(!empty($team_settings_tab))
                    foreach ($team_settings_tab as $tab){
                        $id = $tab['id'];
                        $title = $tab['title'];
                        $active = $tab['active'];
                        $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                        $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                        $is_pro = isset($tab['is_pro']) ? $tab['is_pro'] : false;
                        $pro_text = isset($tab['pro_text']) ? $tab['pro_text'] : '';


                        ?>
                        <li <?php if(!empty($data_visible)):  ?> data_visible="<?php echo $data_visible; ?>" <?php endif; ?> class="tab-nav <?php if($hidden) echo 'hidden';?> <?php if($active) echo 'active';?>" data-id="<?php echo $id; ?>">
                            <?php echo $title; ?>
                            <?php
                            if($is_pro):
                                ?><span class="pro-feature"><?php echo $pro_text; ?></span> <?php
                            endif;
                            ?>

                        </li>
                        <?php
                    }
                    ?>



                </ul>



                <?php

                if(!empty($team_settings_tab))
                foreach ($team_settings_tab as $tab){
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    ?>

                    <div class="tab-content <?php if($active) echo 'active';?>" id="<?php echo $id; ?>">
                        <?php
                        do_action('team_settings_content_'.$id, $tab);
                        ?>


                    </div>

                    <?php
                }
                ?>

                <div class="clear clearfix"></div>
                <p class="submit">
                    <?php wp_nonce_field( 'team_nonce' ); ?>
                    <input class="button button-primary" type="submit" name="Submit" value="<?php _e('Save Changes','team' ); ?>" />
                </p>

            </div>


		</form>
</div>
