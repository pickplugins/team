<?php
if ( ! defined('ABSPATH')) exit;  // if direct access





add_action('team_single_team_member', 'team_single_team_member');

function team_single_team_member($team_member_id){

    $team_member_data = get_post_meta( $team_member_id, 'team_member_data', true );
    $item_layout_id = !empty($team_member_data['layout_id']) ? $team_member_data['layout_id'] : team_first_team_layout();
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );

    //var_dump($item_layout_id);

    ?>

    <div class="elements-wrapper layout-<?php echo $item_layout_id; ?>">
        <?php

        if(!empty($layout_elements_data))
        foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

            if(!empty($elementGroupData))
            foreach ($elementGroupData as $elementIndex => $elementData){
                $args['team_member_id'] = $team_member_id;
                $args['elementData'] = $elementData;
                $args['element_index'] = $elementGroupIndex;

                do_action('team_layout_element_'.$elementIndex, $args);
            }
        }
        ?>
    </div>

    <?php

}




add_action('team_single_team_member', 'team_single_team_member_custom_css');

function team_single_team_member_custom_css($team_member_id){


    $team_member_data = get_post_meta( $team_member_id, 'team_member_data', true );
    $item_layout_id = !empty($team_member_data['layout_id']) ? $team_member_data['layout_id'] : team_first_team_layout();

    $custom_scripts = get_post_meta($item_layout_id,'custom_scripts', true);
    $custom_css = isset($custom_scripts['custom_css']) ? $custom_scripts['custom_css'] : '';
    $custom_js = isset($custom_scripts['custom_js']) ? $custom_scripts['custom_js'] : '';
    $layout_elements_data = get_post_meta( $item_layout_id, 'layout_elements_data', true );

    $args['layout_id'] = $item_layout_id;


    ?>
    <style type="text/css">

        <?php

        echo str_replace('__ID__', 'layout-'.$item_layout_id, $custom_css);

        ?>
    </style>

    <?php

    if(!empty($layout_elements_data))
    foreach ($layout_elements_data as $elementGroupIndex => $elementGroupData){

        if(!empty($elementGroupData))
        foreach ($elementGroupData as $elementIndex => $elementData){


            $args['elementData'] = $elementData;
            $args['element_index'] = $elementGroupIndex;

            //echo $elementIndex;
            do_action('team_layout_element_css_'.$elementIndex, $args);
        }
    }


}



