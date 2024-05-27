<?php
if (!defined('ABSPATH')) exit;  // if direct access 

add_filter('the_content', 'team_preview_content');
function team_preview_content($content)
{
    if (is_singular('team')) {
        $post_id = get_the_id();
        $content .= do_shortcode('[team id="' . $post_id . '"]');
    }

    return $content;
}


function team_first_team_member()
{

    $args = array(
        'post_type' => 'team_member',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );

    $post_id = '';

    $wp_query = new WP_Query($args);

    if ($wp_query->have_posts()) :
        while ($wp_query->have_posts()) : $wp_query->the_post();
            $team_member_id = get_the_id();
            return $team_member_id;
        endwhile;
    else :

    endif;
}


function team_first_team_layout()
{

    $args = array(
        'post_type' => 'team_layout',
        'post_status' => 'publish',
        'posts_per_page' => 1,
    );

    $post_id = '';

    $wp_query = new WP_Query($args);

    if ($wp_query->have_posts()) :
        while ($wp_query->have_posts()) : $wp_query->the_post();

            $post_id = get_the_id();

            return $post_id;
        endwhile;
    else :

    endif;
}






add_image_size('team-500px', 500, 500, true);
add_theme_support('post-thumbnails', array('team_member'));

function team_term_slug_list($post_id)
{

    $term_slug_list = '';
    $post_taxonomies = get_post_taxonomies($post_id);

    foreach ($post_taxonomies as $taxonomy) {

        $term_list[] = wp_get_post_terms(get_the_ID(), $taxonomy, array("fields" => "all"));
    }

    if (!empty($term_list)) {
        foreach ($term_list as $term_key => $term) {
            foreach ($term as $term_id => $term) {
                $term_slug_list .= $term->slug . ' ';
            }
        }
    }

    return $term_slug_list;
}







function single_team_member_content($content)
{

    if (is_singular('team_member')) {

        $team_id = get_the_id();

        ob_start();

?>
        <div class="team-member single-team-member">
            <?php
            do_action('team_single_team_member', $team_id);
            ?>
        </div>
    <?php



        $content =  ob_get_clean();
        return $content;
    } else {
        return $content;
    }
}

add_filter('the_content', 'single_team_member_content');



function single_team_member_post_title($post_title)
{

    if (is_singular('team_member') && in_the_loop()) {
        $team_settings = get_option('team_settings');
        $hide_post_title = isset($team_settings['team_member']['hide_post_title']) ? $team_settings['team_member']['hide_post_title'] : '';

        if ($hide_post_title == 'yes') return;


        return $post_title;
    } else {
        return $post_title;
    }
}

add_filter('the_title', 'single_team_member_post_title');


function single_team_member_post_thumbnail($post_thumbnail)
{

    if (is_singular('team_member')) {
        $team_settings = get_option('team_settings');
        $hide_featured_image = isset($team_settings['team_member']['hide_featured_image']) ? $team_settings['team_member']['hide_featured_image'] : '';

        //var_dump($hide_featured_image);

        if ($hide_featured_image == 'yes') return;


        return $post_thumbnail;
    } else {
        return $post_thumbnail;
    }
}

add_filter('post_thumbnail_html', 'single_team_member_post_thumbnail');






add_filter('manage_team_member_posts_columns', 'team_add_thumb_column');

function team_add_thumb_column($columns)
{
    $columns['thumb'] = __('Thumb', 'team');
    return $columns;
}



add_action('manage_team_member_posts_custom_column', 'team_member_posts_thumb_display', 10, 2);

function team_member_posts_thumb_display($column, $post_id)
{

    if ($column == 'thumb') {
        $team_thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'thumbnail');
        $team_thumb_url = isset($team_thumb['0']) ? $team_thumb['0'] : '';

        $team_member_data = get_post_meta($post_id, 'team_member_data', true);
        $member_image_id = isset($team_member_data['member_image']) ? $team_member_data['member_image'] : '';
        $member_image_url = wp_get_attachment_url($member_image_id, 'full');

        //var_dump($member_image_id);

        if (!empty($member_image_url))
            echo '<img width="40px"  src="' . $member_image_url . '">';
    }
}




function team_add_shortcode_column($columns)
{
    return array_merge(
        $columns,
        array('shortcode' => __('Shortcode', 'team'))
    );
}
add_filter('manage_team_posts_columns', 'team_add_shortcode_column');


function team_posts_shortcode_display($column, $post_id)
{
    if ($column == 'shortcode') {
    ?>
        <input style="background:#bfefff" type="text" onClick="this.select();" value="[team <?php echo 'id=&quot;' . $post_id . '&quot;'; ?>]" /><br />
        <textarea cols="50" rows="1" style="background:#bfefff" onClick="this.select();"><?php echo '<?php echo do_shortcode("[team id=';
                                                                                            echo "'" . $post_id . "']";
                                                                                            echo '"); ?>'; ?></textarea>
<?php

    }
}
add_action('manage_team_posts_custom_column', 'team_posts_shortcode_display', 10, 2);




function team_recursive_sanitize_arr($array)
{

    foreach ($array as $key => &$value) {
        if (is_array($value)) {
            $value = team_recursive_sanitize_arr($value);
        } else {
            $value = wp_kses_post($value);
        }
    }

    return $array;
}


add_shortcode('team_import_xml_layouts', 'team_import_xml_layouts');

function team_import_xml_layouts($xml_source)
{


    if (!current_user_can('manage_options')) return;


    $response = array();
    $user_id = get_current_user_id();




    $json_obj = file_get_contents($xml_source);

    //$xml_json = json_encode($html_obj);
    $xml_arr = json_decode($json_obj, true);


    $items = $xml_arr['rss']['channel']['item'];

    foreach ($items as $item) {

        $post_title = isset($item['title']) ? $item['title'] : '';
        $postmeta = isset($item['postmeta']) ? $item['postmeta'] : array();

        $post_id = wp_insert_post(
            array(
                'post_title'    => $post_title,
                'post_content'  => '',
                'post_status'   => 'publish',
                'post_type'       => 'team_layout',
                'post_author'   => $user_id,
            )
        );

        //            echo '<br>';
        //            echo $post_title. ' Created';
        //            echo '<br>';


        foreach ($postmeta as $meta) {

            $meta_key = isset($meta['meta_key']['__cdata']) ? $meta['meta_key']['__cdata'] : '';
            $meta_value = isset($meta['meta_value']['__cdata']) ? $meta['meta_value']['__cdata'] : '';

            //            echo '<br>';
            //            //var_dump(unserialize($meta_value));
            //            echo '<br>';



            if ($meta_key == 'layout_options' || $meta_key == 'layout_elements_data' || $meta_key == 'custom_scripts') {
                //var_dump($meta_value);

                update_post_meta($post_id, $meta_key, unserialize($meta_value));
            }
        }
    }


    $response['success'] = __('Import done', 'team');

    $team_plugin_info = get_option('team_plugin_info');

    if (strpos($xml_source, 'team-pro')) {
        $team_plugin_info['import_pro_layouts'] = 'done';
    } else {
        $team_plugin_info['import_layouts'] = 'done';
    }


    update_option('team_plugin_info', $team_plugin_info);
}
