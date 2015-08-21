<?php
/**
 * Created by PhpStorm.
 * User: BitBytes
 * Date: 8/10/2015
 * Time: 10:11 PM
 */
add_shortcode('client-list', 'get_client_list_view');

function get_client_list_view(){
    ob_start();
    echo "";
    echo '';
?>

    <div class='client-list-wrapper'>
        <div class="client-list-left">
            <div id="demoSix-nav" class="listNav"></div>
        </div>
        <div class="client-list-right">
        <ul id="demoSix" class="demo">
<?php

    $client = new WP_Query(array(
        'post_type' => 'client',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC'));
    //foreach($content as $key => $value)
    while($client->have_posts()): $client->the_post();

            $title = get_the_title();
            $related_testimonial = get_field('client_testimonial');
            if(!empty($related_testimonial))
                echo '<li style="display: list-item;" class="ln-'.strtolower(substr($title,0,1)).' has-testimonial"><span class="fa fa-pencil-square"></span>
<a href="#">'.$title.'</a></li>';
            else
                echo '<li style="display: list-item;" class="ln-'.strtolower(substr($title,0,1)).' no-testimonial"><a href="#">'.$title.'</a></li>';
    endwhile;
    ?>
    </ul>
    </div>
<?php
    $output = ob_get_clean();

    return $output;
}