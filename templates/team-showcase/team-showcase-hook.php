<?php
if ( ! defined('ABSPATH')) exit;  // if direct access






add_action('team_showcase_main', 'team_showcase_main_nav_top', 5);

function team_showcase_main_nav_top($atts){

    $post_id = isset($atts['id']) ? sanitize_text_field($atts['id']) : '';

    //if(empty($post_id)) return;

    $team_options = get_post_meta($post_id, 'team_options', true);
    $team_members = !empty($team_options['team_members']) ? $team_options['team_members'] : array();




}


add_action('team_showcase_main', 'team_showcase_main_team_members', 5);

function team_showcase_main_team_members($atts){

    $post_id = isset($atts['id']) ? sanitize_text_field($atts['id']) : '';

    //if(empty($post_id)) return;

    $team_options = get_post_meta($post_id, 'team_options', true);
    $team_members = !empty($team_options['team_members']) ? $team_options['team_members'] : array();



    ?>
    <div class="team-items">
        <?php
        if(!empty($team_members)):
            foreach ($team_members as $index => $team_member ):
                $class = !empty($team_member['class']) ? $team_member['class'] : '';

                $item_class = 'item';
                $item_class .= ' '.$class;

                $item_class = apply_filters('team_showcase_loop_item_class', $item_class, $team_member);

                ?>
                <div <?php echo apply_filters('team_showcase_loop_item_attr', '', $team_member); ?> class="<?php echo $item_class; ?>">
                    <?php

                    do_action('team_showcase_loop_item', $atts, $team_member);
                    //echo '<pre>'.var_export($team_member, true).'</pre>';

                    ?>
                </div>
                <?php

            endforeach;
        endif;
        ?>
    </div>
    <?php

    //echo '<pre>'.var_export($team_members, true).'</pre>';

}

add_action('team_showcase_loop_item', 'team_showcase_loop_item', 5, 2);

function team_showcase_loop_item($atts, $team_member){

    if(!empty($team_member)):
        foreach ($team_member as $elementIndex => $element ):

            do_action('team_showcase_loop_item_element_'.$elementIndex, $atts, $element);
            //echo '<pre>'.var_export($index, true).'</pre>';

        endforeach;
    endif;

}

add_action('team_showcase_loop_item_element_name', 'team_showcase_loop_item_element_name', 5, 2);

function team_showcase_loop_item_element_name($atts, $element){

    //echo '<pre>'.var_export($element, true).'</pre>';

    ?>
    <div class="team-title"><?php echo $element; ?></div>
    <?php
}