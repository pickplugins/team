<?php
if ( ! defined('ABSPATH')) exit;  // if direct access


//add_action('testimonial_install', 'testimonial_install_data_update');

//add_shortcode('testimonialData', 'testimonial_install_data_update');


function testimonial_install_data_update(){

    $testimonial_options = array();

    $testimonial_data_update = get_option('testimonial_data_update');


    if($testimonial_data_update == 'yes'){
        return;

    }


    $args = array(
        'post_type'=>'testimonial',
        'post_status'=>'publish',
        'posts_per_page'=> -1,

    );



    $wp_query = new WP_Query($args);

    $testimonialData = array();

    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $post_id = get_the_id();
            $testimonialData[$post_id]['name'] = get_the_title();
            $testimonialData[$post_id]['content'] = get_the_content();
            $testimonialData[$post_id]['thumbnail'] = get_post_thumbnail_id( $post_id );

            $my_post = array(
                'ID'           => $post_id,
                'post_status'   => 'trash',

            );

            wp_update_post( $my_post );


        endwhile;
    endif;

    if(empty($testimonialData)){
        return;
    }

    $postData = array('post_title'=>'Testimonial showcase - update version', 'post_type'=>'testimonial','post_status'=>'publish' );

    $id = wp_insert_post($postData);

    $testimonial_options['testimonials'] = $testimonialData;



    update_post_meta($id, 'testimonial_options', $testimonial_options);



    //update_option('testimonial_data_update', 'yes');

}





add_action('testimonial_install', 'testimonial_template_data');

function testimonial_template_data(){

    $templtaeData = array (
        47336 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#3d3d3d',
                                        'text-align' => 'right',
                                        'margin' => '0px 110px 0px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#ffcb23',
                                        'text-align' => 'right',
                                        'margin' => '0px 110px 0px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#3d3d3d',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'right',
                                        'border-radius' => '5px',
                                        'margin' => '15px 110px 0px 0',
                                        'padding' => '15px',
                                        'float' => 'none',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'right',
                                        'margin' => '0 auto',
                                        'padding' => '',
                                        'text-align' => 'center',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5b5b5b',
                                        'text-align' => 'right',
                                        'margin' => '0px 110px 0px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#3d3d3d',
                                        'text-align' => 'right',
                                        'margin' => '0px 110px 0px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element thumbnail">{{thumbnail}}</div>
<div class="element arrow-right-top content">{{content}}</div> 
<div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div>
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 

</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47335 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5b5b5b',
                                        'text-align' => 'left',
                                        'margin' => '0 0 0px 120px',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'left',
                                        'margin' => '0 0 0px 120px',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'left',
                                        'border-radius' => '5px',
                                        'margin' => '15px 0 0px 110px',
                                        'padding' => '15px',
                                        'float' => 'none',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'left',
                                        'margin' => '0 auto',
                                        'padding' => '',
                                        'text-align' => 'center',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5b5b5b',
                                        'text-align' => 'left',
                                        'margin' => '0 0 0px 120px',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5b5b5b',
                                        'text-align' => 'left',
                                        'margin' => '0 0 0px 120px',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element thumbnail">{{thumbnail}}</div> 
<div class="element arrow-left-top content">{{content}}</div> 
<div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 

</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47326 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'center',
                                        'margin' => '5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'center',
                                        'margin' => '5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'right',
                                        'border-radius' => '5px',
                                        'margin' => '0 0 20px 0',
                                        'padding' => '15px',
                                        'float' => 'none',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'none',
                                        'margin' => '0 auto',
                                        'padding' => '',
                                        'text-align' => 'center',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'center',
                                        'margin' => '5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'center',
                                        'margin' => ' 5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element arrow-bottom-middle content">{{content}}</div> 
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 

</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47325 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#444444',
                                        'text-align' => 'center',
                                        'margin' => '5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'center',
                                        'margin' => '5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'center',
                                        'border-radius' => '5px',
                                        'margin' => '15px 0px 0px 0',
                                        'padding' => '15px',
                                        'float' => 'none',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'none',
                                        'margin' => '0 auto',
                                        'padding' => '',
                                        'text-align' => 'center',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#444444',
                                        'text-align' => 'center',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#444444',
                                        'text-align' => 'center',
                                        'margin' => ' 5px 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 
<div class="element arrow-top-middle content">{{content}}</div> 
</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47324 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#353535',
                                        'text-align' => 'right',
                                        'margin' => '0  120px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'right',
                                        'margin' => '0  120px 0 0 ',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'left',
                                        'border-radius' => '5px',
                                        'margin' => '0 0 16px 0',
                                        'padding' => '15px',
                                        'float' => 'left',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'right',
                                        'margin' => '0 5px 0 0',
                                        'padding' => '',
                                        'text-align' => 'left',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'right',
                                        'margin' => '0  120px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#353535',
                                        'text-align' => 'right',
                                        'margin' => '0  120px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element arrow-bottom-right content">{{content}}</div>
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 
 
</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47323 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'left',
                                        'border-radius' => '5px',
                                        'margin' => '0 0 20px 0',
                                        'padding' => '15px',
                                        'float' => 'left',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'left',
                                        'margin' => '0 20px 0 0',
                                        'padding' => '',
                                        'text-align' => 'left',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'left',
                                        'margin' => '0 20px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#5e5e5e',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element arrow-bottom-left content">{{content}}</div> 
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 

</div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
        47322 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'right',
                                        'margin' => '0  130px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'right',
                                        'margin' => '0  130px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#4c4c4c',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'left',
                                        'border-radius' => '5px',
                                        'margin' => '0 20px 0px 0',
                                        'padding' => '15px',
                                        'float' => 'left',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'right',
                                        'margin' => '0 15px 20px 0',
                                        'padding' => '',
                                        'text-align' => 'left',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'right',
                                        'margin' => '0  130px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'right',
                                        'margin' => '0  130px 0 0',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 
<div class="element arrow-top-right content">{{content}}</div> 
</div>
<div class="clear"></div>',
                'template_css' => '',
            ),
        47321 =>
            array (
                'layout_items_sort' =>
                    array (
                        'name' => '',
                        'rating' => '',
                        'content' => '',
                        'thumbnail' => '',
                        'company_name' => '',
                        'position' => '',
                    ),
                'layout_items' =>
                    array (
                        'name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'rating' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#efcd21',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'content' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '15px',
                                        'color' => '#4c4c4c',
                                        'background-color' => '#f4f4f4',
                                        'text-align' => 'left',
                                        'border-radius' => '5px',
                                        'margin' => '0 20px 0px 0',
                                        'padding' => '15px',
                                        'float' => 'left',
                                    ),
                            ),
                        'thumbnail' =>
                            array (
                                'settings' =>
                                    array (
                                        'thumbSize' => 'left',
                                    ),
                                'style' =>
                                    array (
                                        'width' => '90px',
                                        'height' => '90px',
                                        'border-radius' => '50%',
                                        'float' => 'left',
                                        'margin' => '0 15px 20px 0',
                                        'padding' => '',
                                        'text-align' => 'left',
                                    ),
                            ),
                        'company_name' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                        'position' =>
                            array (
                                'style' =>
                                    array (
                                        'font-size' => '',
                                        'color' => '#4c4c4c',
                                        'text-align' => 'left',
                                        'margin' => '',
                                        'padding' => '',
                                        'float' => 'none',
                                    ),
                            ),
                    ),
                'template_html' => '<div class="item-wrap"> 
<div class="element thumbnail">{{thumbnail}}</div> <div class="element name">{{name}}</div> 
<div class="element position">{{position}}</div> 
<div class="element company_name">{{company_name}}</div> 
<div class="element rating">{{rating}}</div> 
<div class="element arrow-top-left content">{{content}}</div> 
</div>
<div class="clear"></div>',
                'template_css' => '.item-wrap{}
.item-wrap .element.thumbnail{}
.item-wrap .element.name{}
.item-wrap .element.position{}
.item-wrap .element.company_name{}
.item-wrap .element.rating{}
',
            ),
    );




    $testimonial_template_update = get_option('testimonial_template_update');

    if($testimonial_template_update == 'yes'){
        return;

    }

    include('class-media-upload-by-url.php');


    $images = array(
        testimonial_plugin_url.'assets/admin/images/template0.jpg',
        testimonial_plugin_url.'assets/admin/images/template1.jpg',
        testimonial_plugin_url.'assets/admin/images/template2.jpg',
        testimonial_plugin_url.'assets/admin/images/template3.jpg',
        testimonial_plugin_url.'assets/admin/images/template4.jpg',
        testimonial_plugin_url.'assets/admin/images/template5.jpg',
        testimonial_plugin_url.'assets/admin/images/template6.jpg',
        testimonial_plugin_url.'assets/admin/images/template7.jpg',

    );

    $MediaUploadByURL = new MediaUploadByURL();

    $i = 0;

    foreach ($templtaeData as $data):

        $postData = array('post_title'=>'Template '.$i, 'post_type'=>'testimonial_template','post_status'=>'publish' );

        $id = wp_insert_post($postData);
        update_post_meta($id, 'testimonial_options', $data);

        $args = array(
            'file_src_url'      => $images[$i], // Optional
            'file_title' 	    => 'Testimonial template '.$i, // Optional
            'type'           => 'image/jpg', // Second
            'timeout'           => 20, // Second



        );



        $fileId = $MediaUploadByURL->upload_file($args);

        update_post_meta($id, '_thumbnail_id', $fileId);

        $i++;
    endforeach;



    update_option('testimonial_template_update', 'yes');










}












add_shortcode('update_team_data', 'update_team_data');


function update_team_data(){

    $testimonial_options = array();


    $args = array(
        'post_type'=>'team',
        'post_status'=>'any',
        'posts_per_page'=> -1,

    );



    $wp_query = new WP_Query($args);

    $testimonialData = array();

    if ( $wp_query->have_posts() ) :
        while ( $wp_query->have_posts() ) : $wp_query->the_post();

            $post_id = get_the_id();
            $team_options = array();



            $team_bg_img = get_post_meta( $post_id, 'team_bg_img', true );
            $team_container_bg_color = get_post_meta( $post_id, 'team_container_bg_color', true );
            $team_themes = get_post_meta( $post_id, 'team_themes', true );
            $team_social_icon_style = get_post_meta( $post_id, 'team_social_icon_style', true );
            $team_masonry_enable = get_post_meta( $post_id, 'team_masonry_enable', true );
            $team_grid_item_align = get_post_meta( $post_id, 'team_grid_item_align', true );
            $team_item_text_align = get_post_meta( $post_id, 'team_item_text_align', true );
            $team_total_items = get_post_meta( $post_id, 'team_total_items', true );
            $team_pagination_display = get_post_meta( $post_id, 'team_pagination_display', true );
            $team_query_order = get_post_meta( $post_id, 'team_query_order', true );
            $team_query_orderby = get_post_meta( $post_id, 'team_query_orderby', true );
            $team_query_orderby_meta_key = get_post_meta( $post_id, 'team_query_orderby_meta_key', true );
            $team_content_source = get_post_meta( $post_id, 'team_content_source', true );
            $team_content_year = get_post_meta( $post_id, 'team_content_year', true );
            $team_content_month = get_post_meta( $post_id, 'team_content_month', true );
            $team_content_month_year = get_post_meta( $post_id, 'team_content_month_year', true );
            $team_taxonomy_terms = get_post_meta( $post_id, 'team_taxonomy_terms', true );
            $team_post_ids = get_post_meta( $post_id, 'team_post_ids', true );
            $team_items_title_color = get_post_meta( $post_id, 'team_items_title_color', true );
            $team_items_title_font_size = get_post_meta( $post_id, 'team_items_title_font_size', true );
            $team_items_title_font_family = get_post_meta( $post_id, 'team_items_title_font_family', true );

            $team_items_position_color = get_post_meta( $post_id, 'team_items_position_color', true );
            $team_items_position_font_size = get_post_meta( $post_id, 'team_items_position_font_size', true );
            $team_items_position_font_family = get_post_meta( $post_id, 'team_items_position_font_family', true );
            $team_items_content = get_post_meta( $post_id, 'team_items_content', true );
            $team_items_content_color = get_post_meta( $post_id, 'team_items_content_color', true );
            $team_items_content_font_size = get_post_meta( $post_id, 'team_items_content_font_size', true );
            $team_items_content_font_family = get_post_meta( $post_id, 'team_items_content_font_family', true );
            $team_pagination_bg_color = get_post_meta( $post_id, 'team_pagination_bg_color', true );
            $team_pagination_active_bg_color = get_post_meta( $post_id, 'team_pagination_active_bg_color', true );
            $team_items_excerpt_count = (int)get_post_meta( $post_id, 'team_items_excerpt_count', true );
            $team_items_excerpt_text = get_post_meta( $post_id, 'team_items_excerpt_text', true );
            $team_items_thumb_size = get_post_meta( $post_id, 'team_items_thumb_size', true );
            $team_items_link_to_post = get_post_meta( $post_id, 'team_items_link_to_post', true );
            $team_items_max_width = get_post_meta( $post_id, 'team_items_max_width', true );
            $team_items_width_tablet = get_post_meta( $post_id, 'team_items_width_tablet', true );
            $team_items_width_mobile = get_post_meta( $post_id, 'team_items_width_mobile', true );
            $team_items_thumb_max_hieght = get_post_meta( $post_id, 'team_items_thumb_max_hieght', true );
            $team_items_thumb_max_hieght_tablet = get_post_meta( $post_id, 'team_items_thumb_max_hieght_tablet', true );
            $team_items_thumb_max_hieght_mobile = get_post_meta( $post_id, 'team_items_thumb_max_hieght_mobile', true );
            $team_items_margin = get_post_meta( $post_id, 'team_items_margin', true );
            $team_items_social_icon_type = get_post_meta( $post_id, 'team_items_social_icon_type', true );
            $team_items_social_icon_width = get_post_meta( $post_id, 'team_items_social_icon_width', true );
            $team_items_social_icon_height = get_post_meta( $post_id, 'team_items_social_icon_height', true );
            $team_items_social_font_family = get_post_meta( $post_id, 'team_items_social_font_family', true );
            $team_grid_meta_keys = get_post_meta( $post_id, 'team_grid_meta_keys', true );
            $team_items_meta_font_family = get_post_meta( $post_id, 'team_items_meta_font_family', true );



            $team_items_custom_css = get_post_meta( $post_id, 'team_items_custom_css', true );
            $team_items_popup_content = get_post_meta( $post_id, 'team_items_popup_content', true );
            $team_items_popup_excerpt_count = get_post_meta( $post_id, 'team_items_popup_excerpt_count', true );
            $team_items_popup_excerpt_text = get_post_meta( $post_id, 'team_items_popup_excerpt_text', true );
            $team_items_popup_width = get_post_meta( $post_id, 'team_items_popup_width', true );
            $team_items_popup_height = get_post_meta( $post_id, 'team_items_popup_height', true );
            $team_items_popup_thumb_size = get_post_meta( $post_id, 'team_items_popup_thumb_size', true );
            $team_items_popup_thumb_src = get_post_meta( $post_id, 'team_items_popup_thumb_src', true );
            $popup_thumb_src_meta_key = get_post_meta( $post_id, 'popup_thumb_src_meta_key', true );
            $team_grid_items = get_post_meta( $post_id, 'team_grid_items', true );
            $team_grid_items_hide = get_post_meta( $post_id, 'team_grid_items_hide', true );
            $team_items_post_per_page_mixitup = get_post_meta( $post_id, 'team_items_post_per_page_mixitup', true );
            $team_items_default_filter_mixitup = get_post_meta( $post_id, 'team_items_default_filter_mixitup', true );
            $team_items_skill_bg_color = get_post_meta( $post_id, 'team_items_skill_bg_color', true );
            $team_items_skill_sort = get_post_meta( $post_id, 'team_items_skill_sort', true );
            $team_pagination_prev_text = get_post_meta( $post_id, 'team_pagination_prev_text', true );
            $team_pagination_next_text = get_post_meta( $post_id, 'team_pagination_next_text', true );
            $team_grid_style = get_post_meta( $post_id, 'team_grid_style', true );
            $team_pagination_type = get_post_meta( $post_id, 'team_pagination_type', true );
            $team_pagination_top = get_post_meta( $post_id, 'team_pagination_top', true );
            $team_column_number = get_post_meta( $post_id, 'team_column_number', true );
            $team_column_number_mobile = get_post_meta( $post_id, 'team_column_number_mobile', true );
            $team_column_number_tablet = get_post_meta( $post_id, 'team_column_number_tablet', true );
            $team_auto_play = get_post_meta( $post_id, 'team_auto_play', true );
            $team_slide_autoplaySpeed = get_post_meta( $post_id, 'team_slide_autoplaySpeed', true );
            $team_slide_autoplayTimeout = get_post_meta( $post_id, 'team_slide_autoplayTimeout', true );
            $team_slide_loop = get_post_meta( $post_id, 'team_slide_loop', true );
            $team_slide_rewind = get_post_meta( $post_id, 'team_slide_rewind', true );
            $team_slide_center = get_post_meta( $post_id, 'team_slide_center', true );
            $team_slide_rtl = get_post_meta( $post_id, 'team_slide_rtl', true );
            $team_stop_on_hover = get_post_meta( $post_id, 'team_stop_on_hover', true );
            $team_slider_navigation = get_post_meta( $post_id, 'team_slider_navigation', true );
            $team_slider_navigation_position = get_post_meta( $post_id, 'team_slider_navigation_position', true );
            $team_slide_speed = get_post_meta( $post_id, 'team_slide_speed', true );
            $team_slider_pagination = get_post_meta( $post_id, 'team_slider_pagination', true );
            $team_pagination_slide_speed = get_post_meta( $post_id, 'team_pagination_slide_speed', true );
            $team_slider_pagination_count = get_post_meta( $post_id, 'team_slider_pagination_count', true );
            $team_slider_pagination_bg = get_post_meta( $post_id, 'team_slider_pagination_bg', true );
            $team_slider_pagination_text_color = get_post_meta( $post_id, 'team_slider_pagination_text_color', true );
            $team_slider_touch_drag = get_post_meta( $post_id, 'team_slider_touch_drag', true );
            $team_slider_mouse_drag = get_post_meta( $post_id, 'team_slider_mouse_drag', true );
            $team_filter_bg_color = get_post_meta( $post_id, 'team_filter_bg_color', true );
            $team_filter_active_bg_color = get_post_meta( $post_id, 'team_filter_active_bg_color', true );
            $team_filter_text_color = get_post_meta( $post_id, 'team_filter_text_color', true );
            $team_filter_scroll_top = get_post_meta( $post_id, 'team_filter_scroll_top', true );


            // Slider Options
            $team_options['slider_column_desktop'] = $team_column_number;
            $team_options['slider_column_tablet'] = $team_column_number_tablet;
            $team_options['slider_column_mobile'] = $team_column_number_mobile;
            $team_options['slider_auto_play'] = $team_auto_play;
            $team_options['slider_auto_play_speed'] = $team_slide_autoplaySpeed;
            $team_options['slider_auto_play_timeout'] = $team_slide_autoplayTimeout;
            $team_options['slider_slide_speed'] = $team_slide_speed;
            $team_options['slider_pagination_slide_speed'] = $team_pagination_slide_speed;
            $team_options['slider_slideBy'] = $team_column_number;
            $team_options['slider_rewind'] = $team_slide_rewind;
            $team_options['slider_loop'] = $team_slide_loop;
            $team_options['slider_center'] = $team_slide_center;
            $team_options['slider_stop_on_hover'] = $team_stop_on_hover;
            $team_options['slider_navigation'] = $team_slider_navigation;
            $team_options['slider_navigation_position'] = $team_slider_navigation_position;
            $team_options['slider_nav_theme'] = 'navThemes1';
            $team_options['slider_pagination'] = $team_slider_pagination;
            $team_options['slider_pagination_bg'] = $team_slider_pagination_bg;
            $team_options['slider_pagination_bg_active'] = $team_slider_pagination_bg;
            $team_options['slider_pagination_text_color'] = $team_slider_pagination_text_color;
            $team_options['slider_pagination_theme'] = 'dotsThemes1';
            $team_options['slider_touch_drag'] = $team_slider_touch_drag;
            $team_options['slider_mouse_drag'] = $team_slider_mouse_drag;
            $team_options['slider_rtl'] = $team_slide_rtl;
            $team_options['slider_animateout'] = 'none';
            $team_options['slider_animateIn'] = 'none';


            $team_options['filterable_post_per_page'] = $team_items_post_per_page_mixitup;
            $team_options['filterable_default_filter'] = $team_items_default_filter_mixitup;
            $team_options['filterable_filter_bg_color'] = $team_filter_bg_color;
            $team_options['filterable_filter_active_bg_color'] = $team_filter_active_bg_color;
            $team_options['filterable_filter_text_color'] = $team_filter_text_color;
            $team_options['filterable_filter_scroll_top'] = $team_filter_scroll_top;

            $team_options['pagination_prev_text'] = $team_pagination_prev_text;
            $team_options['pagination_next_text'] = $team_pagination_next_text;
            $team_options['pagination_next_text'] = $team_pagination_next_text;
            $team_options['pagination_bg_color'] = $team_pagination_bg_color;
            $team_options['pagination_active_bg_color'] = $team_pagination_active_bg_color;
            $team_options['pagination_at_top'] = $team_pagination_top;
            $team_options['pagination_type'] = $team_pagination_type;


            $team_options['masonry_enable'] = $team_masonry_enable;

            $team_options['grid_type'] = $team_grid_style;
            $team_options['custom_css'] = $team_items_custom_css;
            $team_options['team_theme'] = $team_themes;
            $team_options['team_items_link_to_post'] = $team_items_link_to_post;

            $team_options['item_width_desktop'] = $team_items_max_width;
            $team_options['item_width_tablet'] = $team_items_width_tablet;
            $team_options['item_width_mobile'] = $team_items_width_mobile;
            $team_options['item_margin'] = $team_items_margin;
            $team_options['item_text_align'] = $team_item_text_align;
            $team_options['container_bg_img'] = $team_bg_img;
            $team_options['container_align'] = $team_grid_item_align;
            $team_options['container_bg_color'] = $team_container_bg_color;










            $team_options['team_query_orderby'] = $team_query_orderby;
            $team_options['team_query_orderby_meta_key'] = $team_query_orderby_meta_key;
            $team_options['team_query_order'] = $team_query_order;
            $team_options['team_total_items'] = $team_total_items;
            $team_options['team_taxonomy_terms'] = $team_taxonomy_terms;
            $team_options['team_post_ids'] = $team_post_ids;


            $team_options['team_items_thumb_size'] = $team_items_thumb_size;
            $team_options['team_items_thumb_max_hieght'] = $team_items_thumb_max_hieght;
            $team_options['team_items_thumb_max_hieght_tablet'] = $team_items_thumb_max_hieght_tablet;
            $team_options['team_items_thumb_max_hieght_mobile'] = $team_items_thumb_max_hieght_mobile;
            $team_options['team_items_title_color'] = $team_items_title_color;
            $team_options['team_items_title_font_size'] = $team_items_title_font_size;
            $team_options['team_items_title_font_family'] = $team_items_title_font_family;
            $team_options['team_items_position_color'] = $team_items_position_color;
            $team_options['team_items_position_font_size'] = $team_items_position_font_size;
            $team_options['team_items_position_font_family'] = $team_items_position_font_family;
            $team_options['team_items_content'] = $team_items_content;
            $team_options['team_items_excerpt_count'] = $team_items_excerpt_count;
            $team_options['team_items_excerpt_text'] = $team_items_excerpt_text;
            $team_options['team_items_content_color'] = $team_items_content_color;
            $team_options['team_items_content_font_size'] = $team_items_content_font_size;
            $team_options['team_items_content_font_family'] = $team_items_content_font_family;
            $team_options['team_items_social_icon_type'] = $team_items_social_icon_type;
            $team_options['team_items_social_icon_width'] = $team_items_social_icon_width;
            $team_options['team_items_social_icon_height'] = $team_items_social_icon_height;
            $team_options['team_social_icon_style'] = $team_social_icon_style;
            $team_options['team_items_social_font_family'] = $team_items_social_font_family;

            $team_options['team_items_popup_content'] = $team_items_popup_content;
            $team_options['team_items_popup_excerpt_count'] = $team_items_popup_excerpt_count;
            $team_options['team_items_popup_excerpt_text'] = $team_items_popup_excerpt_text;

            $team_options['team_items_popup_width'] = $team_items_popup_width;
            $team_options['team_items_popup_height'] = $team_items_popup_height;
            $team_options['team_items_popup_thumb_src'] = $team_items_popup_thumb_src;
            $team_options['popup_thumb_src_meta_key'] = $popup_thumb_src_meta_key;
            $team_options['team_grid_meta_keys'] = $team_grid_meta_keys;
            $team_options['team_items_meta_font_family'] = $team_items_meta_font_family;

            $team_options['team_items_skill_bg_color'] = $team_items_skill_bg_color;
            $team_options['team_items_skill_sort'] = $team_items_skill_sort;




        endwhile;
    endif;


    ?>
    <pre><?php echo var_export($team_options, true); ?></pre>

    <?php



}


//add_shortcode('update_testimonial_showcase', 'update_testimonial_showcase');

//add_action('testimonial_install', 'update_testimonial_showcase');



    function update_testimonial_showcase(){


        $testimonial_options = array();

        $testimonial_data_update = get_option('testimonial_data_update');


        if($testimonial_data_update == 'yes'){
            return;

        }


        $args = array(
            'post_type'=>'testimonial',
            'post_status'=>'publish',
            'posts_per_page'=> -1,

        );



        $wp_query = new WP_Query($args);

        $testimonialData = array();

        if ( $wp_query->have_posts() ) :
            while ( $wp_query->have_posts() ) : $wp_query->the_post();

                $post_id = get_the_id();
                $testimonialData[$post_id]['name'] = get_the_title();
                $testimonialData[$post_id]['content'] = get_the_content();
                $testimonialData[$post_id]['thumbnail'] = get_post_thumbnail_id( $post_id );

                $my_post = array(
                    'ID'           => $post_id,
                    'post_status'   => 'trash',

                );

                wp_update_post( $my_post );


            endwhile;
        endif;

        wp_reset_query();
        wp_reset_postdata();

        //var_dump($testimonialData);

        if(empty($testimonialData)){
            return;
        }

        $args = array(
            'post_type'=>'testimonial_showcase',
            'post_status'=>'publish',
            'posts_per_page'=> -1,

        );
        $wp_query_showcase = new WP_Query($args);

        if ( $wp_query_showcase->have_posts() ) :
            while ( $wp_query_showcase->have_posts() ) : $wp_query_showcase->the_post();

                $post_id = get_the_id();


                echo $post_id;

                $testimonial_options['testimonials'] = $testimonialData;



                update_post_meta($post_id, 'testimonial_options', $testimonial_options);


                $my_post = array(
                    'ID'           => $post_id,
                    'post_type'   => 'testimonial',
                );

                wp_update_post( $my_post );

            endwhile;
        endif;



        update_option('testimonial_data_update', 'yes');

    }



		
		
		
		

		
		