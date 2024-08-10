<?php
if (!defined('ABSPATH')) exit;  // if direct access

add_action('team_settings_content_general', 'team_settings_content_general');

function team_settings_content_general()
{
    $settings_tabs_field = new settings_tabs_field();

    $team_settings = get_option('team_settings');

    $team_member_slug = isset($team_settings['team_member_slug']) ? $team_settings['team_member_slug'] : '';
    $custom_meta_fields = isset($team_settings['custom_meta_fields']) ? $team_settings['custom_meta_fields'] : '';
    $custom_social_fields = isset($team_settings['custom_social_fields']) ? $team_settings['custom_social_fields'] : '';

?>
    <div class="section">
        <div class="section-title"><?php echo __('General', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some general options.', 'team'); ?></p>

        <?php

        $args = array(
            'id'        => 'team_member_slug',
            'parent' => 'team_settings',
            'title'        => __('Team member slug', 'team'),
            'details'    => __('Write custom team member slug.', 'team'),
            'type'        => 'text',
            'value'        => $team_member_slug,
            'default'        => '',
            'placeholder'        => 'volunteers',
        );

        $settings_tabs_field->generate_field($args);


        $meta_fields = array(

            array(
                'id'        => 'name',
                'title'        => __('Meta Name', 'team'),
                'details'    => __('Write meta field name here.', 'team'),
                'type'        => 'text',
                'value'        => '',
                'default'        => '',
                'placeholder'        => 'Address',
            ),
            array(
                'id'        => 'meta_key',
                'title'        => __('Meta key', 'team'),
                'details'    => __('Write meta key here.', 'team'),
                'type'        => 'text',
                'value'        => '',
                'default'        => '',
                'placeholder'        => 'meta_key',
            ),


        );


        $args = array(
            'id'        => 'custom_meta_fields',
            'parent'        => 'team_settings',
            'title'        => __('Custom meta fields', 'text-domain'),
            'details'    => __('Custom meta fields on team member profile', 'text-domain'),
            'collapsible' => true,
            'type'        => 'repeatable',
            'limit'        => 10,
            'title_field'        => 'name',
            'value'        => $custom_meta_fields,
            'fields'    => $meta_fields,
        );

        $settings_tabs_field->generate_field($args);




        $social_field = array(

            array(
                'id'        => 'name',
                'title'        => __('Meta Name', 'team'),
                'details'    => __('Write meta field name here.', 'team'),
                'type'        => 'text',
                'value'        => '',
                'default'        => '',
                'placeholder'        => '',
            ),
            array(
                'id'        => 'meta_key',
                'title'        => __('Meta key', 'team'),
                'details'    => __('Write meta key here.', 'team'),
                'type'        => 'text',
                'value'        => '',
                'default'        => '',
                'placeholder'        => 'meta_key',
            ),

            array(
                'id'        => 'icon',
                'title'        => __('Add icon', 'team'),
                'details'    => __('Upload icon image here.', 'team'),
                'type'        => 'media_url',
                'value'        => '',
                'default'        => '',
                'placeholder'        => '',
            ),

            array(
                'id'        => 'font_icon',
                'title'        => __('Add font icon', 'team'),
                'details'    => __('Add font icon html here, you can use <a href="https://fontawesome.com/icons">fontawesome</a>  ex: <code> &lt;i class="fab fa-facebook-square">&lt;/i></code>.', 'team'),
                'type'        => 'text',
                'value'        => '',
                'default'        => '',
                'placeholder'        => '<i class=&quot;fab fa-facebook-square&quot;></i>',
            ),

            array(
                'id'        => 'visibility',
                'title'        => __('Visibility', 'team'),
                'details'    => __('Choose visibility.', 'team'),
                'type'        => 'select',
                'value'        => '',
                'default'        => '',
                'args'        => array('1' => 'Yes', '' => 'No'),
            ),

        );


        $args = array(
            'id'        => 'custom_social_fields',
            'parent'        => 'team_settings',
            'title'        => __('Custom social fields', 'text-domain'),
            'details'    => __('Custom social fields on team member profile', 'text-domain'),
            'collapsible' => true,
            'type'        => 'repeatable',
            'limit'        => 10,
            'title_field'        => 'name',
            'value'        => $custom_social_fields,
            'fields'    => $social_field,
        );

        $settings_tabs_field->generate_field($args);



        ?>

    </div>

<?php





}

add_action('team_settings_content_team_member', 'team_settings_content_team_member');

function team_settings_content_team_member()
{
    $settings_tabs_field = new settings_tabs_field();

    $team_settings = get_option('team_settings');

    $hide_featured_image = isset($team_settings['team_member']['hide_featured_image']) ? $team_settings['team_member']['hide_featured_image'] : '';
    $hide_post_title = isset($team_settings['team_member']['hide_post_title']) ? $team_settings['team_member']['hide_post_title'] : '';
    $is_public = isset($team_settings['team_member']['is_public']) ? $team_settings['team_member']['is_public'] : '';

?>
    <div class="section">
        <div class="section-title"><?php echo __('Single team member', 'team'); ?></div>
        <p class="description section-description"><?php echo __('Choose some options for single team member page.', 'team'); ?></p>


        <?php

        $args = array(
            'id'        => 'hide_featured_image',
            'parent' => 'team_settings[team_member]',
            'title'        => __('Hide featured image', 'team'),
            'details'    => __('Hide feature image from single team member page.', 'team'),
            'type'        => 'select',
            'value'        => $hide_featured_image,
            'default'        => '',
            'args'        => array('no' => 'No', 'yes' => 'Yes'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'hide_post_title',
            'parent' => 'team_settings[team_member]',
            'title'        => __('Hide post title', 'team'),
            'details'    => __('Hide post title from single team member page.', 'team'),
            'type'        => 'select',
            'value'        => $hide_post_title,
            'default'        => '',
            'args'        => array('no' => 'No', 'yes' => 'Yes'),
        );

        $settings_tabs_field->generate_field($args);

        $args = array(
            'id'        => 'is_public',
            'parent' => 'team_settings[team_member]',
            'title'        => __('Team member page allow access', 'team'),
            'details'    => __('Allow access to single team member page..', 'team'),
            'type'        => 'select',
            'value'        => $is_public,
            'default'        => '',
            'args'        => array('yes' => 'Yes', 'no' => 'No',),
        );

        $settings_tabs_field->generate_field($args);

        ?>
    </div>
    <?php
}

add_action('team_settings_content_help_support', 'team_settings_content_help_support');

if (!function_exists('team_settings_content_help_support')) {
    function team_settings_content_help_support($tab)
    {

        $settings_tabs_field = new settings_tabs_field();

    ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get support', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Use following to get help and support from our expert team.', 'team'); ?></p>

            <?php


            $layouts_free_url = team_plugin_url . 'sample-data/team-layouts.xml';
            $layouts_free_url_json = team_plugin_url . 'sample-data/team-layouts.json';


            ob_start();
            ?>

            <p><b>Team</b> provide some ready layouts to get started, please follow the steps bellow to import default layouts.</p>

            <p><?php echo __('Import free layouts', 'team'); ?></p>



            <a class="button" href="<?php echo esc_url_raw($layouts_free_url); ?>"><?php echo __('Download XML', 'team'); ?></a>

            <p>Import manually</p>

            <ul>
                <li>Step - 1: Go to <a href="<?php echo admin_url(); ?>import.php">import</a> menu and install & activate <b>WordPress</b> Importer plugin. click to "Install Now" button to install.</li>
                <li>Step - 2: Download following xml file by clicking button bellow, save the file on your local machine.</li>
                <li>Step - 3: Go to importer page <a href="<?php echo admin_url(); ?>import.php?import=wordpress">Import WordPress</a> and chose the downloaded file and then click to <b>Upload file and import</b>.</li>
                <li>Step - 4: Go to <a href="<?php echo admin_url(); ?>edit.php?post_type=team_layout">Team layouts</a> page to see imported layouts.</li>
            </ul>




            <?php
            if (is_plugin_active('team-pro/team-pro.php')) {

                $layouts_pro_url = team_pro_plugin_url . 'sample-data/team-layouts.xml';
                $layouts_pro_url_json = team_pro_plugin_url . 'sample-data/team-layouts.json';


                if ($layouts_pro_url) :
            ?>
                    <p><?php echo __('Import premium layouts', 'team'); ?></p>

                    <a class="button" href="<?php echo esc_url_raw($layouts_pro_url); ?>"><?php echo __('Download Pro XML', 'team'); ?></a>

            <?php
                endif;
            }
            ?>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'import_layouts',
                //'parent'		=> '',
                'title'        => __('Import layouts', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);



            ob_start();
            ?>
            <ul>
                <li>Step - 1: Go to Tools > <a href="<?php echo admin_url(); ?>export.php">Export</a> menu.</li>
                <li>Step - 2: Choose "Team layouts" post types from list.</li>
                <li>Step - 3: Then click to "Download Export File' button.</li>
                <li>Step - 4: Save the file on your local machine.</li>
            </ul>

            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'export_layouts',
                //'parent'		=> '',
                'title'        => __('Export layouts', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);






            ob_start();
            ?>

            <p><?php echo __('Ask question for free on our forum and get quick reply from our expert team members.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/create-support-ticket/"><?php echo __('Create support ticket', 'team'); ?></a>

            <p><?php echo __('Read our documentation before asking your question.', 'team'); ?></p>
            <a class="button" href="https://www.pickplugins.com/documentation/team/"><?php echo __('Documentation', 'team'); ?></a>

            <p><?php echo __('Watch video tutorials.', 'team'); ?></p>
            <a class="button" href="https://www.youtube.com/playlist?list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy"><i class="fab fa-youtube"></i> <?php echo __('All tutorials', 'team'); ?></a>

            <ul>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=SOe0D-Og3nQ&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=1">How to install plugin & setup</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zdaRmH_KGCI&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=2">How to create team showcase</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=T2LyT-K4TF8&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=3">Display team showcase slider</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zcWP-rB1xG0&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=4">Create filterable style grid</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=HjrePb90ToA&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=5">Add custom filter</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=8AWlEOLmgA4&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=6">Create glossary grid</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=n1aiPFL7QoM&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=7">Team showcase masonry style</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=zDGM9KQxQbg&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=8">Team showcase pagination</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=0YBEhSOXSeI&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=9">Team showcase customize layouts</a></li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=A5ARR__VimA&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=10">Query team members ids</a> [pro]</li>
                <li><i class="far fa-dot-circle"></i> <a href="https://www.youtube.com/watch?v=TtwkAKgYG-M&list=PL0QP7T2SN94atYZswlnBMhDuIYoqlmlxy&index=11">Customize team member page</a></li>

            </ul>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'get_support',
                //'parent'		=> '',
                'title'        => __('Ask question', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);


            ob_start();
            ?>

            <p class="">We wish your 2 minutes to write your feedback about the team plugin. give us <span style="color: #ffae19"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></span></p>

            <a target="_blank" href="https://wordpress.org/plugins/team/#reviews" class="button"><i class="fab fa-wordpress"></i> Write a review</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'reviews',
                //'parent'		=> '',
                'title'        => __('Submit reviews', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);





            ob_start();
            ?>

            <p class="">You can install older version by uninstalling current version, your data still on database, don't worry if you see content missing on frontend.</p>

            <a target="_blank" href="https://wordpress.org/plugins/team/advanced/#plugin-download-history-stats" class="button"><i class="fab fa-wordpress"></i> Download older version</a>


            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'old_version',
                //'parent'		=> '',
                'title'        => __('Older version', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);




            ?>


        </div>
    <?php


    }
}






add_action('team_settings_content_buy_pro', 'team_settings_content_buy_pro');

if (!function_exists('team_settings_content_buy_pro')) {
    function team_settings_content_buy_pro($tab)
    {

        $settings_tabs_field = new settings_tabs_field();


    ?>
        <div class="section">
            <div class="section-title"><?php echo __('Get Premium', 'team'); ?></div>
            <p class="description section-description"><?php echo __('Thanks for using our plugin, if you looking for some advance feature please buy premium version.', 'team'); ?></p>

            <?php


            ob_start();
            ?>

            <p><?php echo __('If you love our plugin and want more feature please consider to buy pro version.', 'team'); ?></p>
            <a class="button" href="https://pickplugins.com/team/?ref=dashobard"><?php echo __('Buy premium', 'team'); ?></a>
            <a class="button" href="https://www.pickplugins.com/demo/team/?ref=dashobard"><?php echo __('See all demo', 'team'); ?></a>

            <h2><?php echo __('See the differences', 'team'); ?></h2>

            <table class="pro-features">
                <thead>
                    <tr>
                        <th class="col-features"><?php echo __('Features', 'team'); ?></th>
                        <th class="col-free"><?php echo __('Free', 'team'); ?></th>
                        <th class="col-pro"><?php echo __('Premium', 'team'); ?></th>
                    </tr>
                </thead>

                <tr>
                    <td class="col-features"><?php echo __('View type - Slider', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/slider/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('View type - Filterable', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/filterable/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('View type - Glossary', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/glossary-custom-index/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Access to layout library(30+ ready layout)', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Query by team members id', 'team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - jQuery', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Ajax', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/ajax-pagination/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Load more', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/load-more/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Skill', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/skill-bars/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members link to - Popup box', 'team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members link to - Popup slider', 'team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Team members custom class', 'team'); ?></td>
                    <td><i class="fas fa-times"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('View type - Grid', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/view-type-grid/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Masonry style grid', 'team'); ?> <a href="https://www.pickplugins.com/demo/team/masonry/?ref=dashobard"><?php echo __('Demo', 'team'); ?></a></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item custom width', 'team'); ?> </td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item margin', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Item text align', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Container style', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout builder', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Wrapper start', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Wrapper end', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Thumbnail', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Title', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Position', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Content', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Layout element - Social', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Layout element - Meta fields', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Pagination type - Normal', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Hide Pagination', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom CSS', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom JS', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>



                <tr>
                    <td class="col-features"><?php echo __('Hide featured image(Team member page)', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Hide post title(Team member page)', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom team member slug', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Custom meta fields', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <td class="col-features"><?php echo __('Custom social fields', 'team'); ?></td>
                    <td><i class="fas fa-check"></i></td>
                    <td><i class="fas fa-check"></i></td>
                </tr>

                <tr>
                    <th class="col-features"><?php echo __('Features', 'team'); ?></th>
                    <th class="col-free"><?php echo __('Free', 'team'); ?></th>
                    <th class="col-pro"><?php echo __('Premium', 'team'); ?></th>
                </tr>
                <tr>
                    <td class="col-features"><?php echo __('Buy now', 'team'); ?></td>
                    <td> </td>
                    <td><a class="button" href="https://pickplugins.com/team/?ref=dashobard"><?php echo __('Buy premium', 'team'); ?></a></td>
                </tr>

            </table>



            <?php

            $html = ob_get_clean();

            $args = array(
                'id'        => 'get_pro',
                //                'parent'		=> 'related_post_settings',
                'title'        => __('Get pro version', 'team'),
                'details'    => '',
                'type'        => 'custom_html',
                'html'        => $html,

            );

            $settings_tabs_field->generate_field($args);


            ?>


        </div>

        <style type="text/css">
            .pro-features {
                margin: 30px 0;
                border-collapse: collapse;
                border: 1px solid #ddd;
            }

            .pro-features th {
                width: 120px;
                background: #ddd;
                padding: 10px;
            }

            .pro-features tr {}

            .pro-features td {
                border-bottom: 1px solid #ddd;
                padding: 10px 10px;
                text-align: center;
            }

            .pro-features .col-features {
                width: 230px;
                text-align: left;
            }

            .pro-features .col-free {}

            .pro-features .col-pro {}

            .pro-features i.fas.fa-check {
                color: #139e3e;
                font-size: 16px;
            }

            .pro-features i.fas.fa-times {
                color: #f00;
                font-size: 17px;
            }
        </style>
<?php


    }
}









add_action('team_settings_save', 'team_settings_save');

function team_settings_save()
{

    $team_settings = isset($_POST['team_settings']) ?  team_recursive_sanitize_arr($_POST['team_settings']) : array();
    update_option('team_settings', $team_settings);
}
