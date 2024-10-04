<?php
if (! defined('ABSPATH')) exit;  // if direct access

class class_team_post_meta_team_member
{

    public function __construct()
    {

        //meta box action for "team"
        add_action('add_meta_boxes', array($this, 'team_post_meta_team'));
        add_action('save_post', array($this, 'meta_boxes_team_save'));
    }


    public function team_post_meta_team($post_type)
    {

        add_meta_box('metabox-team_member', __('Team member', 'team'), array($this, 'meta_box_team_data'), 'team_member', 'normal', 'high');
    }






    public function meta_box_team_data($post)
    {

        // Add an nonce field so we can check for it later.
        wp_nonce_field('team_nonce_check', 'team_nonce_check_value');

        // Use get_post_meta to retrieve an existing value from the database.
        // $team_data = get_post_meta($post -> ID, 'team_data', true);

        $post_id = $post->ID;


        $settings_tabs_field = new settings_tabs_field();

        $team_member_settings_tab = array();

        $team_member_settings_tab[] = array(
            'id' => 'general',
            'title' => sprintf(__('%s General', 'team'), '<i class="fas fa-cog"></i>'),
            'priority' => 1,
            'active' => true,
        );

        $team_member_settings_tab[] = array(
            'id' => 'social',
            'title' => sprintf(__('%s Social', 'team'), '<i class="fas fa-share-alt"></i>'),
            'priority' => 2,
            'active' => false,
        );

        $team_member_settings_tab[] = array(
            'id' => 'layouts',
            'title' => sprintf(__('%s Layouts', 'team'), '<i class="fas fa-qrcode"></i>'),
            'priority' => 3,
            'active' => false,
        );


        $team_member_settings_tab = apply_filters('team_member_metabox_navs', $team_member_settings_tab);

        $tabs_sorted = array();
        foreach ($team_member_settings_tab as $page_key => $tab) $tabs_sorted[$page_key] = isset($tab['priority']) ? $tab['priority'] : 0;
        array_multisort($tabs_sorted, SORT_ASC, $team_member_settings_tab);

        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-accordion');

        wp_enqueue_style('jquery-ui');
        wp_enqueue_style('font-awesome-5');
        wp_enqueue_style('settings-tabs');
        wp_enqueue_script('settings-tabs');


        //$team_options = get_post_meta($post_id,'team_options', true);
        //echo '<pre>'.var_export($team_options, true).'</pre>';
        $team_options = get_post_meta($post_id, 'team_options', true);
        $view_type = isset($team_options['view_type']) ? $team_options['view_type'] : 'grid';

?>



        <div class="settings-tabs vertical">

            <ul class="tab-navs">
                <?php
                foreach ($team_member_settings_tab as $tab) {
                    $id = $tab['id'];
                    $title = $tab['title'];
                    $active = $tab['active'];
                    $data_visible = isset($tab['data_visible']) ? $tab['data_visible'] : '';
                    $hidden = isset($tab['hidden']) ? $tab['hidden'] : false;
                ?>
                    <li <?php if (!empty($data_visible)):  ?> data_visible="<?php echo esc_attr($data_visible); ?>" <?php endif; ?> class="tab-nav <?php if ($hidden) echo 'hidden'; ?> <?php if ($active) echo 'active'; ?>" data-id="<?php echo esc_attr($id); ?>"><?php echo wp_kses_post($title); ?></li>
                <?php
                }
                ?>
            </ul>
            <?php
            foreach ($team_member_settings_tab as $tab) {
                $id = $tab['id'];
                $title = $tab['title'];
                $active = $tab['active'];
            ?>

                <div class="tab-content <?php if ($active) echo 'active'; ?>" id="<?php echo esc_attr($id); ?>">
                    <?php
                    do_action('team_member_metabox_content_' . $id, $post_id);
                    ?>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="clear clearfix"></div>

<?php


    }




    public function meta_boxes_team_save($post_id)
    {

        /*
         * We need to verify this came from the our screen and with
         * proper authorization,
         * because save_post can be triggered at other times.
         */

        // Check if our nonce is set.
        if (!isset($_POST['team_nonce_check_value']))
            return $post_id;

        $nonce = sanitize_text_field($_POST['team_nonce_check_value']);

        // Verify that the nonce is valid.
        if (!wp_verify_nonce($nonce, 'team_nonce_check'))
            return $post_id;

        // If this is an autosave, our form has not been submitted,
        //     so we don't want to do anything.
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return $post_id;

        // Check the user's permissions.
        if ('page' == $_POST['post_type']) {

            if (!current_user_can('edit_page', $post_id))
                return $post_id;
        } else {

            if (!current_user_can('edit_post', $post_id))
                return $post_id;
        }

        /* OK, its safe for us to save the data now. */

        do_action('team_member_metabox_save', $post_id);
    }
}


new class_team_post_meta_team_member();
