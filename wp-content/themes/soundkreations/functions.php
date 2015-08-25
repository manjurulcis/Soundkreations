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
    ?>

    <div id="lfb_loader"></div>
    <div id="lfb_bootstraped" class="lfb_bootstraped">
        <div id="estimation_popup" data-form="3" class="wpe_bootstraped  ">
            <a id="wpe_close_btn" href="javascript:"><span class="fui-cross"></span></a>

            <div id="wpe_panel">
                <div class="container-fluid">
                    <div class="row">
                        <div class="">
                            <div id="startInfos">
                                <h1>HOW MUCH TO MAKE MY WEBSITE ?</h1>

                                <p>Estimate the cost of a website easily using this awesome tool.</p>
                            </div>
                            <p>
                                <a href="javascript:" onclick="jQuery('#startInfos > p').slideDown();"
                                   class="btn btn-large btn-primary" id="btnStart">GET STARTED</a>
                            </p>

                            <div id="genPrice" class="genPrice">
                                <div class="progress">
                                    <div class="progress-bar" style="width: 0%;">
                                        <div class="progress-bar-price">
                                            0 $
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- /genPrice -->
                            <h2 id="finalText" class="stepTitle">Thanks, we will contact you soon</h2>
                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->
                    <div id="mainPanel" class="palette-clouds" data-savecart="0">
                        <div class="genSlide" data-start="1" data-stepid="13" data-title="Tell Us About Yourself"
                             data-dependitem="0"><h2 class="stepTitle">Tell Us About Yourself</h2>

                            <div class="genContent container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"><label>First Name</label>
                                            <input type="text" data-itemid="73" class="form-control"
                                                   data-required="true" data-title="First Name"
                                                   data-originaltitle="First Name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Last Name</label>
                                            <input type="text" data-itemid="74" class="form-control"
                                                   data-required="true" data-title="Last Name"
                                                   data-originaltitle="Last Name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Email Address</label>
                                            <input type="text" data-itemid="75" class="form-control"
                                                   data-title="Email Address" data-originaltitle="Email Address"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Confirm Email Address</label>
                                            <input type="text" data-itemid="76" class="form-control"
                                                   data-required="true" data-title="Confirm Email Address"
                                                   data-originaltitle="Confirm Email Address"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p>
                                            <label>Region</label>
                                            <br/>
                                            <select class="form-control" data-originaltitle="Region" data-itemid="77"
                                                    data-title="Region">
                                                <option value="Calgary Area">Calgary Area</option>
                                                <option value="Edmonton Area">Edmonton Area</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="errorMsg alert alert-danger">You need to select an item to continue</div>
                            <p style="margin-top: 42px;" class="text-center"><a href="javascript:"
                                                                                class="btn btn-wide btn-primary btn-next">NEXT
                                    STEP</a></p></div>
                        <div class="genSlide" data-start="0" data-stepid="14" data-title="Program Style"
                             data-dependitem="0"><h2 class="stepTitle">Program Style</h2>

                            <div class="genContent container-fluid">
                                <div class="row">
                                    <div class="col-md-12"><p>
                                            <label>Program 1</label>
                                            <br/>
                                            <input type="checkbox" class="" data-operation="+"
                                                   data-originaltitle="Program 1" data-itemid="78" data-prodid="0"
                                                   data-required="true" data-toggle="switch" data-price="0"
                                                   data-title="Program 1"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="errorMsg alert alert-danger">You need to select an item to continue</div>
                            <p style="margin-top: 42px;" class="text-center"><a href="javascript:"
                                                                                class="btn btn-wide btn-primary btn-next">NEXT
                                    STEP</a><br/><a href="javascript:" class="linkPrevious">return to previous step</a>
                            </p></div>
                        <div class="genSlide" data-start="0" data-stepid="15" data-title="Program Format"
                             data-dependitem="0"><h2 class="stepTitle">Program Format</h2>

                            <div class="genContent container-fluid">
                                <div class="row">
                                    <div class="col-md-12"><p>
                                            <label>Program Format 1</label>
                                            <br/>
                                            <input type="checkbox" class="" data-operation="+"
                                                   data-originaltitle="Program Format 1" data-itemid="79"
                                                   data-prodid="0" data-required="true" data-toggle="switch"
                                                   data-price="0" data-title="Program Format 1"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="errorMsg alert alert-danger">You need to select an item to continue</div>
                            <p style="margin-top: 42px;" class="text-center"><a href="javascript:"
                                                                                class="btn btn-wide btn-primary btn-next">NEXT
                                    STEP</a><br/><a href="javascript:" class="linkPrevious">return to previous step</a>
                            </p></div>
                        <div class="genSlide" data-start="0" data-stepid="16" data-title="Choose Dates"
                             data-required="true" data-dependitem="0"><h2 class="stepTitle">Choose Dates</h2>

                            <div class="genContent container-fluid">
                                <div class="row">
                                    <div class="col-md-12"><p>
                                            <label>Program Format 1</label>
                                            <br/>
                                            <input type="checkbox" class="" data-operation="+"
                                                   data-originaltitle="Program Format 1" data-itemid="80"
                                                   data-prodid="0" data-required="true" data-toggle="switch"
                                                   data-price="0" data-title="Program Format 1"/>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="errorMsg alert alert-danger">You need to select an item to continue</div>
                            <p style="margin-top: 42px;" class="text-center"><a href="javascript:"
                                                                                class="btn btn-wide btn-primary btn-next">NEXT
                                    STEP</a><br/><a href="javascript:" class="linkPrevious">return to previous step</a>
                            </p></div>
                        <div class="genSlide" data-start="0" data-stepid="17" data-title="School Info"
                             data-dependitem="0"><h2 class="stepTitle">School Info</h2>

                            <div class="genContent container-fluid">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group"><label>First Name</label>
                                            <input type="text" data-itemid="81" class="form-control"
                                                   data-required="true" data-title="First Name"
                                                   data-originaltitle="First Name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Last Name</label>
                                            <input type="text" data-itemid="82" class="form-control"
                                                   data-required="true" data-title="Last Name"
                                                   data-originaltitle="Last Name"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Email Address</label>
                                            <input type="text" data-itemid="83" class="form-control"
                                                   data-title="Email Address" data-originaltitle="Email Address"/>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group"><label>Confirm Email Address</label>
                                            <input type="text" data-itemid="84" class="form-control"
                                                   data-required="true" data-title="Confirm Email Address"
                                                   data-originaltitle="Confirm Email Address"/>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <p>
                                            <label>Region</label>
                                            <br/>
                                            <select class="form-control" data-originaltitle="Region" data-itemid="85"
                                                    data-title="Region">
                                                <option value="Calgary Area">Calgary Area</option>
                                                <option value="Edmonton Area">Edmonton Area</option>
                                                <option value="Other">Other</option>
                                            </select>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="errorMsg alert alert-danger">You need to select an item to continue</div>
                            <p style="margin-top: 42px;" class="text-center"><a href="javascript:"
                                                                                class="btn btn-wide btn-primary btn-next">NEXT
                                    STEP</a><br/><a href="javascript:" class="linkPrevious">return to previous step</a>
                            </p></div>
                        <div class="genSlide" id="finalSlide" data-stepid="final">
                            <h2 class="stepTitle">Final cost</h2>

                            <div class="genContent">
                                <div class="genContentSlide active">
                                    <p>The final estimated price is : </p>

                                    <h3 id="finalPrice" style=""></h3>

                                    <div class="form-group"><label for="field_15" style="display: block">Do you want to
                                            write a message ?</label><input id="field_15_cb" type="checkbox"
                                                                            data-toggle="switch"
                                                                            data-fieldid="15"/><br/><textarea
                                            id="field_15" data-required="false" class="form-control toggle "
                                            placeholder=""></textarea></div>
                                    <div class="form-group"><label for="field_18"
                                                                   style="display: none">Email</label><input type="text"
                                                                                                             id="field_18"
                                                                                                             data-required="false"
                                                                                                             placeholder="Email"
                                                                                                             class="form-control emailField "/>
                                    </div>
                                    <div class="form-group"><label for="field_21"
                                                                   style="display: none">Email</label><input type="text"
                                                                                                             id="field_21"
                                                                                                             data-required="false"
                                                                                                             placeholder="Email"
                                                                                                             class="form-control emailField "/>
                                    </div>
                                    <div class="form-group"><label for="field_24"
                                                                   style="display: none">Email</label><input type="text"
                                                                                                             id="field_24"
                                                                                                             data-required="false"
                                                                                                             placeholder="Email"
                                                                                                             class="form-control emailField "/>
                                    </div>
                                    <div class="form-group"><label for="field_26"
                                                                   style="display: none">Email</label><input type="text"
                                                                                                             id="field_26"
                                                                                                             data-required="false"
                                                                                                             placeholder="Email"
                                                                                                             class="form-control emailField "/>
                                    </div>
                                    <p style="margin-bottom: 28px;"><a href="javascript:" id="wpe_btnOrder"
                                                                       class="btn btn-wide btn-primary">ORDER MY
                                            WEBSITE</a><br/><a href="javascript:" class="linkPrevious">return to
                                            previous step</a></p></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php

    $output = ob_get_clean();

    return $output;

}

add_action( 'wp_ajax_get_currentRef', 'get_currentRef_callback' );
function get_currentRef_callback(){
    echo "3";
    exit();
}