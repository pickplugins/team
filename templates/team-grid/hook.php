<?php
if (!defined('ABSPATH')) exit;  // if direct access

add_action('testimonial_builder_testimonialGrid', 'testimonial_builder_testimonialGrid', 5, 2);

function testimonial_builder_testimonialGrid($post_id, $accordionData)
{

    global $testimonialBuilderCss;


    $globalOptions = isset($accordionData["globalOptions"]) ? $accordionData["globalOptions"] : [];
    $lazyLoad = isset($globalOptions["lazyLoad"]) ? $globalOptions["lazyLoad"] : false;
    $itemSource = isset($globalOptions["itemSource"]) ? $globalOptions["itemSource"] : "topToBottom";

    //var_dump($globalOptions);



    $items = isset($accordionData["items"]) ? $accordionData["items"] : [];
    $itemQueryArgs = isset($accordionData["itemQueryArgs"]) ? $accordionData["itemQueryArgs"] : [];


    // if ($itemSource == "posts") {
    //     $items = testimonial_post_query_items($itemQueryArgs);
    // }
    // if ($itemSource == "terms") {
    //     $items = testimonial_terms_query_item($itemQueryArgs);
    // }
    // if ($itemSource == "easyAccordion") {
    //     $items = testimonial_easy_accordion_query_item($itemQueryArgs);
    // }



    $reponsiveCss = isset($accordionData["reponsiveCss"]) ? $accordionData["reponsiveCss"] : "";

    //var_dump($reponsiveCss);

    $testimonialBuilderCss .= $reponsiveCss;



    $loopLayout = isset($accordionData["loopLayout"]) ? $accordionData["loopLayout"] : [];

    $loopLayouts = $loopLayout[0]['children'];
    $wrapper = isset($accordionData["wrapper"]) ? $accordionData["wrapper"] : [];
    $wrapperOptions = isset($wrapper["options"]) ? $wrapper["options"] : [];
    $wrapperTag = !empty($wrapperOptions["tag"]) ? $wrapperOptions["tag"] : "div";
    $wrapperClass = isset($wrapperOptions["class"]) ? $wrapperOptions["class"] : "";




    $blockId = "testimonial-" . $post_id;

    //echo "<pre>" . var_export($loopLayout, true) . "</pre>";


    $accordionDataAttr = [
        "id" => $blockId,
        "lazyLoad" => $lazyLoad,
    ];



?>
    <div id="<?php echo esc_attr($blockId); ?>" class="pg-accordion-nested  " data-accordionBuilder=<?php echo esc_attr(json_encode($accordionDataAttr)) ?> role="tablist" style="<?php echo ($lazyLoad) ? "display: none;" : ""; ?>">


        <div class="items">
            <?php
            $count = 0;
            foreach ($items as $index => $item) {



                $content = isset($item["content"]) ?  $item["content"] : "";
                $date = isset($item["date"]) ?  $item["date"] : "";
                $rate = isset($item["rate"]) ?  $item["rate"] : 5;
                $avatar = isset($item["avatar"]) ?  $item["avatar"] : [];
                $avatarsrcUrl = isset($item["srcUrl"]) ?  $item["srcUrl"] : "";
                $avatarid = isset($item["id"]) ?  $item["id"] : "";

                $person = isset($item["person"]) ?  $item["person"] : [];
                $personname = isset($item["name"]) ?  $item["name"] : "";
                $personjobTitle = isset($item["jobTitle"]) ?  $item["jobTitle"] : "";
                $personcompany = isset($item["company"]) ?  $item["company"] : [];
                $personcompanyname = isset($item["name"]) ?  $item["name"] : [];
                $personcompanywebsite = isset($item["website"]) ?  $item["website"] : [];






            ?>

                <div class="item">
                    <?php
                    echo generateNestedHTML($loopLayouts, $item);
                    ?>
                </div>



            <?php
                $count++;
            }
            ?>
        </div>

    </div>


    <?php
}


function generateNestedHTML($elements, $itemData)
{
    $html = '';
    foreach ($elements as $element) {

        $type = $element['type'];

        if ($type == 'container') {
            $html .= '<div id="element-' . $element['id'] . '">';

            if (!empty($element['children'])) {
                $html .= generateNestedHTML($element['children'], $itemData);
            }
            $html .= '</div>';
        } else {

            //if (isset($element['content'])) {
            $html .= generateElementHtml($element, $itemData);
        }
    }
    return $html;
}



function generateElementHtml($element, $item)
{

    $type = $element['type'];


    $content = isset($item["content"]) ?  $item["content"] : "";
    $date = isset($item["date"]) ?  $item["date"] : "";
    $rate = isset($item["rate"]) ?  $item["rate"] : 5;
    $avatar = isset($item["avatar"]) ?  $item["avatar"] : [];
    $avatarsrcUrl = isset($item["srcUrl"]) ?  $item["srcUrl"] : "";
    $avatarid = isset($item["id"]) ?  $item["id"] : "";

    $person = isset($item["person"]) ?  $item["person"] : [];
    $personname = isset($person["name"]) ?  $person["name"] : "";
    $personjobTitle = isset($person["jobTitle"]) ?  $person["jobTitle"] : "";
    $personcompany = isset($item["company"]) ?  $item["company"] : [];
    $personcompanyname = isset($personcompany["name"]) ?  $personcompany["name"] : [];
    $personcompanywebsite = isset($personcompany["website"]) ?  $personcompany["website"] : [];



    ob_start();

    if ($type == 'content') {
    ?>
        <div id="element-<?php echo esc_attr($element['id']); ?>">
            <?php echo wp_unslash(wp_specialchars_decode($content, ENT_QUOTES)) ?>
        </div>
    <?php
    }
    if ($type == 'personName') {
    ?>
        <div id="element-<?php echo esc_attr($element['id']); ?>">
            <?php echo wp_kses_post($personname); ?>

        </div>
    <?php
    }
    if ($type == 'rate') {
    ?>
        <div id="element-<?php echo esc_attr($element['id']); ?>">
            <?php echo wp_kses_post($personname); ?>

        </div>
    <?php
    }



    if ($type == 'personAvatar') {
    ?>
        <img id="element-<?php echo esc_attr($element['id']); ?>" src="https://comboblocks.com/server/wp-content/uploads/2024/09/team-member-6.jpg" alt="">
    <?php
    }

    ?>

<?php


    return ob_get_clean();
}
