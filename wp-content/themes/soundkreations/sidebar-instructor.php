<?php
global $avia_config;

##############################################################################
# Display the sidebar
##############################################################################

$default_sidebar = true;
$sidebar_pos = avia_layout_class('main', false);

$sidebar_smartphone = avia_get_option('smartphones_sidebar') == 'smartphones_sidebar' ? 'smartphones_sidebar_active' : "";
$sidebar = "";

if(strpos($sidebar_pos, 'sidebar_left')  !== false) $sidebar = 'left';
if(strpos($sidebar_pos, 'sidebar_right') !== false) $sidebar = 'right';

//filter the sidebar position (eg woocommerce single product pages always want the same sidebar pos)
$sidebar = apply_filters('avf_sidebar_position', $sidebar);
$initial_id = get_the_ID();
//if the layout hasnt the sidebar keyword defined we dont need to display one
if(empty($sidebar)) return;
if(!empty($avia_config['overload_sidebar'])) $avia_config['currently_viewing'] = $avia_config['overload_sidebar'];


echo "<aside class='sidebar sidebar_".$sidebar." ".$sidebar_smartphone." ".avia_layout_class( 'sidebar', false )." units' ".avia_markup_helper(array('context' => 'sidebar', 'echo' => false)).">";
    echo "<div class='inner_sidebar extralight-border'>";

    $instructors = new WP_Query(array(
        'posts_per_page' => -1,
        'post_type' => 'instructor',
        'order_by' => 'title',
        'order' => 'ASC'));
    echo '<nav class="instructors-nav"><ul>';
    echo '<li class="instructor-nav"><a href="'.get_permalink(5649).'">All</a></li>';
    while ($instructors->have_posts()) : $instructors->the_post();
    echo '<li class="instructor-nav'.($initial_id == get_the_ID() ? ' selected' : '').'">';
    echo '<a href="'.get_the_permalink(get_the_ID()).'">'.get_the_title().'</a>';
    echo '</li>';
    endwhile;
    echo '</ul></nav>';

            
        wp_reset_query();
    echo "</div>";
echo "</aside>";






