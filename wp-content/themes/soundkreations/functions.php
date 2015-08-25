<?php



function soundkreations_register_styles() {

}



function soundkreations_register_scripts() {

    wp_enqueue_script("soundkreations_main_script", get_stylesheet_directory_uri() . '/js/main.js', array(), '1.0.0', true);

    wp_enqueue_script("soundkreations_multislider_script", get_stylesheet_directory_uri() . '/js/multi-slider.js', array(), '1.0.0', true);
    wp_enqueue_script("soundkreations_instructors_slider_script", get_stylesheet_directory_uri() . '/js/instructors-slider.js', array(), '1.0.0', true);
    wp_enqueue_script("soundkreations_clientlist_script", get_stylesheet_directory_uri() . '/js/jquery.listnav-2.1.js', array(), '1.0.0', true);
    wp_enqueue_style( 'soundkreations_fontawesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css' );

}



function avia_include_shortcode_template($paths) {

    $template_url = get_stylesheet_directory();

    

    array_unshift($paths, $template_url.'/shortcodes/');

    

    return $paths;

}



add_action('wp_enqueue_scripts', 'soundkreations_register_styles');

add_action('wp_enqueue_scripts', 'soundkreations_register_scripts');



add_filter('avia_load_shortcodes', 'avia_include_shortcode_template', 15, 1);

include_once('includes/client-list.php');

/**
 * Frontend Shortcode Handler
 *
 * @param array $atts array of attributes
 * @param string $content text within enclosing form of shortcode element
 * @param string $shortcodename the shortcode found, when == callback name
 * @return string $output returns the modified html string
 */
function programlist($atts)
{
    extract(shortcode_atts(array('taxnomy_type'=>'all','term_ids'=>'all','readmorelink'=>'','readmoretext'=>''), $atts));

    $output = '<section class="program-list-container">';
    $tax_type = (isset($atts['taxnomy_type']) && $atts['taxnomy_type'] =='all')?'':$atts['taxnomy_type'];
    $term_ids = (isset($atts['term_ids']) && $atts['term_ids'] =='all')?'':$atts['term_ids'];

    $readmoretext = ( $atts['readmoretext'] =='')?'Read More':$atts['readmoretext'];


    $args = array(
        'post_type' => 'program',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC');

    if($tax_type!=""){
        if($term_ids == ''){
            $terms = get_terms($tax_type);
            $ids = array();
            if(count($terms)>0){
                foreach($terms as $term){
                    array_push($ids,$term->term_id);
                }
            }

            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_type,
                    'field' => 'id',
                    'terms' =>  $ids)
            );


        }
        else{
            //return $term_ids;
            //$term_ids = explode($term_ids,',');
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_type,
                    'field' => 'id',
                    'terms' =>  $term_ids)
            );

        }


    }


    $programs = new WP_Query($args);
    $output .= '<ul class="program-list">';
    while ($programs->have_posts()) : $programs->the_post();
        $output .= '<li class="program"><div class="program-inside"> ';


        $output .= '<h3 class="program-name">';
        $output .= get_the_title();
        $output .= '</h3>';

        $output .= '<div class="program-container" style="">';
        $output .= '<div class="program-image">';
        if (has_post_thumbnail()) :

            $output .= get_the_post_thumbnail(get_the_ID(), 'full');

        endif;
        $output .= '</div>';
        $output .= '<div class="program-description"><p>'.get_the_content().'</p>';
        $output .= '</div></div>';
        $output .= '</div>';
        $output .= '<div class="program-read-more">';

        if($atts['readmorelink']!='')
            $output .= '<a class="program-readmore" href="'.$atts['readmorelink'].'">'.$readmoretext.'</a>';
        else
        $output .= '<a class="program-readmore" href="'.get_the_permalink().'">'.$readmoretext.'</a>';

        $output .= '</div>';
        $output .= '</li>';
    endwhile;
    $output .= '</ul>';
    $output .= '</section>';
    wp_reset_query();

    return $output;
}

add_shortcode('programlist','programlist');

/* Build Your Program Shortcode*/

add_shortcode('build-your-program','build_your_program');

function build_your_program($atts){
    extract(shortcode_atts(array('taxnomy_type'=>'all','term_ids'=>'all','readmorelink'=>'','readmoretext'=>''), $atts));
    ob_start();


}