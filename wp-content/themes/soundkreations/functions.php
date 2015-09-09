<?php


function soundkreations_register_styles()
{

}


function soundkreations_register_scripts()
{

    wp_enqueue_script("soundkreations_main_script", get_stylesheet_directory_uri() . '/js/main.js', array(), '1.0.0', true);

    wp_enqueue_script("soundkreations_multislider_script", get_stylesheet_directory_uri() . '/js/multi-slider.js', array(), '1.0.0', true);
    wp_enqueue_script("soundkreations_instructors_slider_script", get_stylesheet_directory_uri() . '/js/instructors-slider.js', array(), '1.0.0', true);
    wp_enqueue_script("soundkreations_clientlist_script", get_stylesheet_directory_uri() . '/js/jquery.listnav-2.1.js', array(), '1.0.0', true);
    wp_enqueue_style('soundkreations_fontawesome', get_stylesheet_directory_uri() . '/css/font-awesome.min.css');

}


function avia_include_shortcode_template($paths)
{

    $template_url = get_stylesheet_directory();


    array_unshift($paths, $template_url . '/shortcodes/');


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
    extract(shortcode_atts(array('taxnomy_type' => 'all', 'term_ids' => 'all', 'readmorelink' => '', 'readmoretext' => ''), $atts));

    $output = '<section class="program-list-container">';
    $tax_type = (isset($atts['taxnomy_type']) && $atts['taxnomy_type'] == 'all') ? '' : $atts['taxnomy_type'];
    $term_ids = (isset($atts['term_ids']) && $atts['term_ids'] == 'all') ? '' : $atts['term_ids'];

    $readmoretext = ($atts['readmoretext'] == '') ? 'Read More' : $atts['readmoretext'];


    $args = array(
        'post_type' => 'program',
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'ASC');

    if ($tax_type != "") {
        if ($term_ids == '') {
            $terms = get_terms($tax_type);
            $ids = array();
            if (count($terms) > 0) {
                foreach ($terms as $term) {
                    array_push($ids, $term->term_id);
                }
            }

            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_type,
                    'field' => 'id',
                    'terms' => $ids)
            );


        } else {
            //return $term_ids;
            //$term_ids = explode($term_ids,',');
            $args['tax_query'] = array(
                array(
                    'taxonomy' => $tax_type,
                    'field' => 'id',
                    'terms' => $term_ids)
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
        $output .= '<div class="program-description"><p>' . get_the_content() . '</p>';
        $output .= '</div></div>';
        $output .= '</div>';
        $output .= '<div class="program-read-more">';

        if ($atts['readmorelink'] != '')
            $output .= '<a class="program-readmore" href="' . $atts['readmorelink'] . '">' . $readmoretext . '</a>';
        else
            $output .= '<a class="program-readmore" href="' . get_the_permalink() . '">' . $readmoretext . '</a>';

        $output .= '</div>';
        $output .= '</li>';
    endwhile;
    $output .= '</ul>';
    $output .= '</section>';
    wp_reset_query();

    return $output;
}

add_shortcode('programlist', 'programlist');

/* Build Your Program Shortcode*/

add_shortcode('build-your-program', 'build_your_program');

function build_your_program($atts)
{
    extract(shortcode_atts(array('taxnomy_type' => 'all', 'term_ids' => 'all', 'readmorelink' => '', 'readmoretext' => ''), $atts));
    ob_start();
    ?>
    <style>
        /*custom font*/
        @import url(http://fonts.googleapis.com/css?family=Montserrat);

        /*form styles*/
        #msform {
            height: 650px;
            width: 1180px;
            margin: 50px auto;
            text-align: center;
            overflow: hidden;
        }

        #msform fieldset {
            background: white;
            border: 0 none;
            border-radius: 3px;
            box-shadow: 0 0 15px 1px rgba(0, 0, 0, 0.4);
            padding: 20px 30px;
            height: 590px;
            box-sizing: border-box;
            width: 80%;
            margin: 0 10%;

            /*stacking fieldsets above each other*/
            position: absolute;
        }

        /*Hide all except first fieldset*/
        #msform fieldset:not(:first-of-type) {
            display: none;
        }

        /*inputs*/
        #msform input, #msform textarea {
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-bottom: 10px;
            width: 75%;
            box-sizing: border-box;
            font-family: montserrat;
            color: #2C3E50;
            font-size: 13px;
        }

        /*buttons*/
        #msform .action-button {
            width: 100px;
            background: #00a5e6;
            font-weight: bold;
            color: white;
            border: 0 none;
            border-radius: 1px;
            cursor: pointer;
            padding: 10px 5px;
            margin: 10px 5px;
        }

        #msform .action-button:hover, #msform .action-button:focus {
            box-shadow: 0 0 0 2px white, 0 0 0 3px #00a5e6;
        }

        #msform fieldset .field-form input {
            width: 100%;
        }

        /*headings*/
        .fs-title {
            font-weight: normal;
            font-size: 13px;
            color: #666;
            margin-bottom: 20px;

        }

        .fs-subtitle {
            font-size: 15px;
            text-transform: uppercase;
            color: #333;
            margin-bottom: 30px;
        }

        /*progressbar*/
        #progressbar {
            margin-bottom: 30px;
            overflow: hidden;
            /*CSS counters to number the steps*/
            counter-reset: step;
        }

        #progressbar li {
            list-style-type: none;
            color: black;
            text-transform: uppercase;
            font-size: 9px;
            width: 14.2%;
            float: left;
            position: relative;
        }

        #progressbar li:before {
            background: white none repeat scroll 0 0;
            border-radius: 15px;
            color: #333;
            content: counter(step, decimal);
            counter-increment: step;
            display: block;
            font-size: 12px;
            line-height: 30px;
            margin: 0 auto 5px;
            width: 30px;
        }

        /*progressbar connectors*/
        #progressbar li:after {
            content: '';
            width: 100%;
            height: 2px;
            background: white;
            position: absolute;
            left: -50%;
            top: 17px;
            z-index: -1; /*put it behind the numbers*/
        }

        #progressbar li:first-child:after {
            /*connector not needed before the first step*/
            content: none;
        }

        /*marking active/completed steps green*/
        /*The number of the step and the connector before it = green*/
        #progressbar li.active:before, #progressbar li.active:after {
            background: #00a5e6;
            color: white;
        }

        .field-form label {
            color: #7d7c7d;
            display: block;

        }

        .field-form {
            margin: 0 auto 10px;
            text-align: center;
            width: 80%;
        }

        .radio-input {
            text-align: left !important;

        }

        .indi_input {
            display: inline-block;
            margin-right: -90px;
            width: 25%;
        }

        .indi_input .left {
            float: left;
            max-width: 60%;
            margin-right: 10px;
        }

        /*Program Selection*/
        .pg-interest {
            max-width: 100%;

        }

        .field-form select{
            margin: 0 auto;
        }

        .pg-interest h3 {
            color: #7d7c7d;
            font-size: 15px;
        }

        .pg-interest .program-list li.program h3.program-name{
            -webkit-background-size: 25px;
            background-size: 25px;
        }
        .pg-interest ul {
            list-style-type: none;
            max-width: 100%;
        }

        .program-selection {
            display: inline-flex;
        }

        .program-selection li {
            width: 20%;
        }

        .indi-program {

        }

        .program-heading {
            background: #3b3f3e;
            margin-top: -3px;
            height: 30px;

        }

        .program-heading h4 {
            font-size: 15px;
            color: white;
            padding: 5px;

        }

        .program-body {
            border-left: 3px solid #fbca04 !important;
            border-right: 3px solid #fbca04 !important;

        }

        .program-body img {
            margin-bottom: -7px;
        }

        .program-footer {
            border: 3px solid #fbca04 !important;
        }

        .program-footer h4 {
            font-size: 12px;
            padding: 5px 0;
        }

        .areatitle {
            max-width: 100%;
            width: 39%;
            margin: 0 auto;
        }

        .areatitle input {

        }

        .areatitle select {

        }

        #msform .getstart {
            background: #00a5e6 none repeat scroll 0 0;
            border: 0 none;
            border-radius: 1px;
            color: white;
            cursor: pointer;
            float: right;
            font-weight: bold;
            margin: 0.5px 4px 0 0;
            padding: 8px 5px;
            width: 90px;
        }

        .program-list li .program-inside {
            padding: 0 10px !important;
        }

        .select-style {
            border: 1px solid #ccc;
            width: 120px;
            border-radius: 3px;
            overflow: hidden;
            background: #fafafa url("img/icon-select.png") no-repeat 90% 50%;
        }
        .select-style select {
            padding: 5px 8px;
            width: 130%;
            border: none;
            box-shadow: none;
            background: transparent;
            background-image: none;
            -webkit-appearance: none;
        }

        .select-style select:focus {
            outline: none;
        }
    </style>

    <!-- multistep form -->
    <form id="msform">
        <!-- progressbar -->
        <ul id="progressbar">
            <li class="active">about us</li>
            <li>program style</li>
            <li>program format</li>
            <li>choose dates</li>
            <li>school info</li>
            <li>message</li>
        </ul>
        <!-- fieldsets -->
        <fieldset>
            <span class="fs-title">Step 1</span>

            <h2 class="fs-subtitle">Tell us about yourself</h2>

            <div class="field-form"><input type="text" id="firstname" name="firstname" placeholder="First Name"
                                           required/></div>
            <div class="field-form"><input type="text" id="lastname" name="lastname" placeholder="Last Name" required/>
            </div>
            <div class="field-form"><input type="email" id="emailad" name="emailad" placeholder="Email Address"
                                           required/></div>
            <div class="field-form"><input type="text" name="postcode" maxlength="5" placeholder="Post Code" required/>
            </div>
            <div class="field-form radio-input"><label for="pastclient">Past SK Client?</label>

                <div class="inputfields">
                    <div class="indi_input">

                        <div class="left"><input type="radio" name="pastclient" value="yes" checked></div>
                        <div class="left"><label>Yes</label></div>
                    </div>
                    <div class="indi_input">

                        <div class="left"><input type="radio" name="pastclient" value="no"></div>
                        <div class="left"><label>No</label></div>
                    </div>
                    <div class="indi_input">
                        <div class="left"><input type="radio" name="pastclient" value="I don't know"></div>
                        <div class="left"><label>I don't know</label></div>
                    </div>
                </div>
            </div>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <h3 class="fs-title">Step 2</h3>

            <h2 class="fs-subtitle">What type of Program are you interested in?</h2>

            <div class="areatitle">
                <input type="button" name="getstarted" class="getstart" value="Get Started">
                <!--<select class="location">

                    <option disabled selected>Choose your area</option>
                    <option value="">Calgary Area</option>
                    <option value="">Edmonton Area</option>
                    <option value="">Other</option>
                </select>-->
                <?php
                 wp_dropdown_categories( array(
                    'show_option_all' => 'Choose your area',
                    'taxonomy' => 'location',
                    'name' => 'location',
                    'orderby' => 'name',
                    'selected' => '',
                    'hierarchical' => false,
                    'depth' => 3,
                    'show_count' => false,
                    'hide_empty' => false,
                ) );
                ?>

                <div class="output"></div>
            </div>
            <!-- All Programs -->

            <div class="pg-interest">
                <h3 class="fs-title"><b>Please choose TWO</b></h3>

            </div>

            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <h3 class="fs-title">Step 3</h3>

            <h2 class="fs-subtitle">What program format are you interested in?</h2>

            <div class="field-form">
                <label for="programselection">
                    Number of students in largest class/class combination
                </label>
                <select required>
                    <option selected>1-45 students</option>
                    <option>46-55 students</option>
                    <option>56-65 students</option>
                    <option>66-75 students</option>
                </select>
            </div>
            <div class="field-form">
                <label for="instructorselection">
                    Number of students in largest class/class combination
                </label>
                <select required>
                    <option selected>1</option>
                    <option>2 (additional charge of $375/day)</option>
                </select>
            </div>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Step 4</h2>

            <h3 class="fs-subtitle">Date Selection</h3>
            <div class="field-form radio-input"><label for="flexibledate">Are dates flexible?</label>
                <div class="inputfields">
                    <div class="indi_input">

                        <div class="left"><input type="radio" name="pastclient" value="yes" checked></div>
                        <div class="left"><label>Yes</label></div>
                    </div>
                    <div class="indi_input">

                        <div class="left"><input type="radio" name="pastclient" value="no"></div>
                        <div class="left"><label>No</label></div>
                    </div>
                </div>
            </div>
            <div class="field-form"><label>How many days are you interested in booking</label><input type="number" name="totaldates" /> </div>
            <div class="field-form"><label>Choose your preferred dates:</label><input type="date" /> </div>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Step 5</h2>

            <h3 class="fs-subtitle">School Info Section</h3>

            <div class="field-form"><label for="schoolname">Name of School you represent</label><input type="text"
                                                                                                       id="schoolname"
                                                                                                       name="schoolname"
                                                                                                       required/></div>
            <div class="field-form"><label for="schooladdress">School Street Address</label><input type="text"
                                                                                                   id="schooladdress"
                                                                                                   name="schooladdress"
                                                                                                   required/></div>
            <div class="field-form"><label for="schoolphone">School Phone Number </label><input type="text"
                                                                                                id="schoolphone"
                                                                                                name="schoolphone"
                                                                                                required/></div>
            <div class="field-form"><label for="grade">Which grades will be participating?</label><input type="text"
                                                                                                         id="grade"
                                                                                                         name="grade"
                                                                                                         required/>
            </div>
            <div class="field-form"><label for="numberofstd">How many students will be participating?</label><input
                    type="text"
                    id="numberofstd"
                    name="numberofstd"
                    required/>
            </div>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="button" name="next" class="next action-button" value="Next"/>
        </fieldset>
        <fieldset>
            <h2 class="fs-title">Step 6</h2>

            <h3 class="fs-subtitle">Is there anything you'd like to tell us?</h3>
            <textarea name="message"
                      placeholder="Please enter any additional notes or messages you wish to pass on to SoundKreations"></textarea>
            <input type="button" name="previous" class="previous action-button" value="Previous"/>
            <input type="submit" name="submit" class="submit action-button" value="Submit"/>
        </fieldset>

    </form>


    <!-- jQuery easing plugin -->
    <script type='text/javascript'
            src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/jquery.easing.min.js'></script>

    <script type="text/javascript">
        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50) + "%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'transform': 'scale(' + scale + ')'});
                    next_fs.css({'left': left, 'opacity': opacity});
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            //show the previous fieldset
            previous_fs.show();
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1 - now) * 50) + "%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({'transform': 'scale(' + scale + ')', 'opacity': opacity});
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function () {
            return false;
        })

        $('#location').change(function(){
            jQuery.post(
                '<?php echo get_bloginfo('url') ?>/wp-admin/admin-ajax.php',
                {
                    'action': 'get_programs_by_location',
                    'location_id':   $('#location option:selected').val()
                },
                function(response){
                    $('.pg-interest').html(response);

                }
            );
        });

    </script>
    <?php

    $output = ob_get_clean();

    return $output;

}

add_action( 'wp_ajax_get_programs_by_location', 'get_programs_by_location' );
add_action( 'wp_ajax_nopriv_get_programs_by_location', 'get_programs_by_location' );

function get_programs_by_location() {
    // Handle request then generate response using WP_Ajax_Response

    $args = array(
        'post_type' => 'program',
        'tax_query' => array(
            array(
                'taxonomy' => 'location',
                'field' => 'id',
                'terms' => $_REQUEST['location_id'],
            ),
        ),
    );
    $query = new WP_Query($args);

    $output = '<section class="program-list-container"><ul class="program-list">';

    while ($query->have_posts()) : $query->the_post();
        $output .= '<li class="program">';


        $output .= '<h3 class="program-name">';
        $output .= get_the_title();
        $output .= '</h3>';

        $output .= '<div class="program-container">';

        if (has_post_thumbnail()) :
            $output .= '<div class="program-image">';
            $output .= get_the_post_thumbnail(get_the_ID(), 'full');
            $output .= '</div>';
        endif;
        $output .= '<div class="program-description"><p>'.get_the_content().'</p>';
        $output .= '</div>';
        $output .= '<div class="program-read-more">';
        $output .= '<a class="program-readmore" href="'.get_the_permalink().'">Read More</a>';
        $output .= '</div></div>';
        $output .= '</li>';
    endwhile;
    $output .= '</ul></section>';
	
	$output.="<script type=\"text/javascript\">

            $(document).ready(function(){
                   $('.program-name').click(function(){
                    $(this).toggleClass('open');
                    $(this).next('div').toggleClass('shown');
                    $(this).parent().parent().toggleClass('expanded');
                });
            });

        </script>";

    echo $output;
    exit;
}
