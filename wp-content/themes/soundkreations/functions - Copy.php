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


    <script type="text/javascript">
        jQuery.noConflict();
    </script>
    <link rel='stylesheet' id='lfb-reset-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/reset.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-bootstrap-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/bootstrap.min.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-flat-ui-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/flat-ui_frontend.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-estimationpopup-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/lfb_forms.css?ver=9.195' type='text/css' media='all' />


    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/bootstrap-switch.js?ver=9.195'></script>
    <script type='text/javascript'>

        /* <![CDATA[ */
        var wpe_forms = [{
            "currentRef": 0,
            "ajaxurl": "http:\/\/localhost\/imagecropper\/wp-admin\/admin-ajax.php",
            "initialPrice": "0",
            "max_price": "0",
            "currency": "$",
            "currencyPosition": "left",
            "intro_enabled": "1",
            "save_to_cart": "0",
            "colorA": "#1abc9c",
            "close_url": "#",
            "animationsSpeed": "0.5",
            "email_toUser": "0",
            "showSteps": "1",
            "formID": "1",
            "gravityFormID": "0",
            "showInitialPrice": "0",
            "disableTipMobile": "0",
            "legalNoticeEnable": "0",
            "links": [{
                "id": "2",
                "formID": "1",
                "originID": "1",
                "destinationID": "2",
                "conditions": "[]"
            },
                {"id": "3", "formID": "1", "originID": "2", "destinationID": "3", "conditions": "[]"},
                {"id": "4", "formID": "1", "originID": "3", "destinationID": "4", "conditions": "[]"},
                {"id":"5","formID":"1","originID":"4","destinationID":"5","conditions":"[]"},
                {"id":"6","formID":"1","originID":"5","destinationID":"6","conditions":"[]"},
                {"id":"7","formID":"1","originID":"6","destinationID":"7","conditions":"[]"},
                {"id":"8","formID":"1","originID":"7","destinationID":"8","conditions":"[]"},
                {"id":"9","formID":"1","originID":"8","destinationID":"9","conditions":"[]"},
                {"id":"10","formID":"1","originID":"9","destinationID":"10","conditions":"[]"},
                {"id":"10","formID":"1","originID":"10","destinationID":"11","conditions":"[]"},
                {"id":"10","formID":"1","originID":"11","destinationID":"12","conditions":"[]"},
                {"id":"10","formID":"1","originID":"12","destinationID":"13","conditions":"[]"},
                {"id":"10","formID":"1","originID":"13","destinationID":"14","conditions":"[]"},
                {"id":"10","formID":"1","originID":"14","destinationID":"15","conditions":"[]"},
                {"id":"10","formID":"1","originID":"15","destinationID":"16","conditions":"[]"},
                {"id":"10","formID":"1","originID":"16","destinationID":"17","conditions":"[]"}],
            "txt_yes": "Yes",
            "txt_no": "No"
        }];
        /* ]]> */
    </script>
    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/lfb_form.min.js?ver=9.195'></script>
    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/lfb_frontend.min.js?ver=9.195'></script>
    <!-- Scripts/CSS and wp_head hook -->

    <div id="lfb_loader"></div><div id="lfb_bootstraped" class="lfb_bootstraped"><div id="estimation_popup" data-form="1" class="wpe_bootstraped  ">
            <a id="wpe_close_btn" href="javascript:"><span class="fui-cross"></span></a>
            <div id="wpe_panel">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="startInfos">
                                <h1>WEBBASIERTE KURZPREISLISTE</h1>
                                <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna</p>
                            </div>
                            <p>
                                <a href="javascript:" onclick="jQuery('#startInfos > p').slideDown();" class="btn btn-large btn-primary" id="btnStart">Los Gehts</a>
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
                            <h2 id="finalText" class="stepTitle">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna</h2>
                        </div>
                        <!-- /col -->
                    </div>
                    <!-- /row -->

                    <div id="mainPanel" class="palette-clouds" data-savecart="0">
                        <div class="container-fluid">
                            <div class="row-fluid">
                                <div class="col-md-3">
                                    <ul class="wizard-sidemenu">
                                        <li><a href="#"> Stammdaten </a></li>
                                        <li><a href="#"> Preisoptionen </a></li>
                                        <li><a href="#"> Portfolioauswahl</a></li>
                                        <li><a href="#"> Zu- & Abschläge</a></li>
                                        <li><a href="#"> Seitenbearbeitung</a></li>
                                        <li><a href="#"> Füllseiten</a></li>
                                        <li><a href="#"> Seitenfolge</a></li>
                                        <li><a href="#"> Vorschau</a></li>
                                        <li><a href="#"> PDF-Export</a></li>
                                        <li><a href="#"> Bestellung</a></li>
                                    </ul>
                                </div>
                                <div class="col-md-9">
                                    <div class="genSlide" data-start="1" data-stepid="1"
                                         data-title="Main Information" data-dependitem="0">
                                        <h2 class="stepTitle">Stammdaten</h2>

                                        <div class="genContent container-fluid">

                                            <div class="col-md-6">
                                                <div class="row-fluid">
                                                    <div class="col-md-12">


                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label class="textleft">Ihre Adresse</label><br/>
                                                                <input type="text" data-itemid="1"
                                                                       class="form-control flexible"
                                                                       data-required="true"
                                                                       data-title="Company Name"
                                                                       data-originaltitle="Company Name"
                                                                       placeholder="Firmenneme"/>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="textleft">Kundennummer</label><br/>
                                                                <input type="text" data-itemid="190"
                                                                       class="form-control flexible"
                                                                       data-required="true"
                                                                       data-title="KUNDENNUMMER"
                                                                       data-originaltitle="KUNDENNUMMER"
                                                                       placeholder="Kundennummer"/>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="textleft">Ansprechpartner</label>
                                                            <input type="text" data-itemid="2"
                                                                   class="form-control flexible half-size"
                                                                   data-required="true" data-title="Name"
                                                                   data-originaltitle="Name"
                                                                   placeholder="Name"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="textleft">Anschrift</label>
                                                            <input type="text" data-itemid="3"
                                                                   class="form-control flexible half-size"
                                                                   data-required="true"
                                                                   data-title="Contact Person"
                                                                   data-originaltitle="Contact Person"
                                                                   placeholder="Strasse"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">

                                                        <div class="form-group">
                                                            <div class="col-md-6">
                                                                <label class="textleft">Postleitzahl </label>
                                                                <input type="text" data-itemid="1"
                                                                       class="form-control flexible"
                                                                       data-required="true" data-title="Plz"
                                                                       data-originaltitle="Plz"
                                                                       placeholder="PLZ"/>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="textleft">Ort</label>
                                                                <input type="text" data-itemid="190"
                                                                       class="form-control flexible"
                                                                       data-required="true" data-title="ORT"
                                                                       data-originaltitle="ORT"
                                                                       placeholder="ORT"/>
                                                            </div>

                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="textleft">eMail-Adresse</label>
                                                            <input type="text" data-itemid="4"
                                                                   class="form-control flexible half-size"
                                                                   data-required="true"
                                                                   placeholder="Ihre eMail"
                                                                   data-title="Email Address "
                                                                   data-originaltitle="Email Address "/>
                                                        </div>
                                                    </div>
                                                    <!--<div class="col-md-12">
                                                        <div class="form-group"><p>Anschrift</p><label>Adresse</label>
                                                            <input type="text" data-itemid="5" class="form-control" data-required="true" data-title="Address" data-originaltitle="Address" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Stadt</label>
                                                            <input type="text" data-itemid="6" class="form-control" data-required="true" data-title="City" data-originaltitle="City" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group"><label>PLZ</label>
                                                            <input type="text" data-itemid="7" class="form-control" data-required="true" data-title="State" data-originaltitle="State" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12"><p>
                                                            <label>Land</label>
                                                            <br/>
                                                            <select class="form-control"  data-originaltitle="Country" data-itemid="8"  data-title="Country" ><option value="United States">USA</option><option value="Germany">Deutschland</option><option value="Finland">Finnland</option></select>
                                                        </p>
                                                    </div>-->
                                                </div>
                                            </div>
                                            <div class="col-md-5 col-md-offset-1">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="textleft">Firmenlogo</label>

                                                        <p style="font-size: 12px;">Hinweis: Wählen Sie hier Ihr Firmenlogo aus der
                                                            Rodenstock Augenoptikerdatenbank aus.</p>
                                                        <input type="file" data-itemid="10"
                                                               class="form-control flexible half-size"
                                                               data-required="true"
                                                               data-title="Company Logo"
                                                               data-originaltitle="Company Logo"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="textleft" style="margin-top: 52px"> Gu?ltigkeitsdatum</label>

                                                        <p style="font-size: 12px">Legen Sie fest, ab welchem Datum Ihre Preisliste
                                                            gu?ltig sein soll. Dieses Datum wird auf dem
                                                            Titelblatt abgedruckt.</p>
                                                        <input type="text" data-itemid="11"
                                                               placeholder="TT.MM.JJJJ"
                                                               class="form-control flexible half-size"
                                                               data-required="true"
                                                               data-title=" Expire Date of Pricelist"
                                                               data-originaltitle=" Expire Date of Pricelist"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next" style="margin-right: 178px !important;">WEITER</a></p>
                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="2"
                                         data-title="Price Options" data-dependitem="0">
                                        <h2 class="stepTitle">Preisoptionen.</h2>

                                        <div class="genContent container-fluid">
                                            <div class="row-fluid">
                                                <div class="col-md-6">
                                                    <div class="row-fluid">
                                                        <div class="col-md-12">
                                                            <p style="text-align: left;font-size: 16px !important; font-weight: bold">
                                                                Preisdarstellung </p>
                                                            <p style="font-size: 12px; text-align: left"> Legen Sie fest, ab welchem Datum Ihre
                                                                Preisliste gu?ltig sein soll. Dieses
                                                                Datum wird auf dem Titelblatt abgedruckt.</p>


                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="col-md-8">
                                                                <label class="sub-head" style="text-align: left;width: 100%; font-size: 16px; font-weight: bold">Unverbindliche
                                                                    Preisempfehlung </label>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div  style="margin-top: 40px" class="selectable checked" data-reduc="0" data-reducqt=""
                                                                      data-operation="+" data-itemid="12" data-prodid="0"
                                                                      data-title="Click to exclude all"  data-group="default-price"
                                                                      step="2"
                                                                      title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                                      data-placement="bottom" data-price="0"><img
                                                                        data-tint="false" src="" alt=""
                                                                        class="img"/><span
                                                                        class="palette-clouds fui-check icon_select"></span>
                                                                </div>
                                                                <!--<div class="form-group">
                                                                    <input type="checkbox"
                                                                           data-group="default-price"
                                                                           class="prechecked"
                                                                           checked
                                                                           data-operation="+"
                                                                           data-originaltitle="Select Default Price "
                                                                           data-itemid="12"
                                                                           data-prodid="0"
                                                                           data-price="0"
                                                                           data-title="Select Default Price "/>

                                                                </div>-->

                                                            </div>


                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="col-md-8">
                                                                <label style="text-align: left;width: 100%;font-size: 16px; font-weight: bold" >Selbst kalkulierte
                                                                    Verkaufspreise</label>

                                                            </div>
                                                            <div class="col-md-4">
                                                                <div  style="margin-top: 40px" class="selectable" data-reduc="0" data-reducqt=""
                                                                      data-operation="+" data-itemid="13" data-prodid="0"
                                                                      data-title="Click to exclude all" data-group="default-price"
                                                                      step="7"
                                                                      title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                                      data-placement="bottom" data-price="0"><img
                                                                        data-tint="false" src="" alt=""
                                                                        class="img"/><span
                                                                        class="palette-clouds fui-cross icon_select"></span>
                                                                </div>
                                                                <!--<input type="checkbox"
                                                                       data-group="default-price"
                                                                       class=""
                                                                       data-operation="+"
                                                                       data-originaltitle="Select Your option"
                                                                       data-itemid="13" data-prodid="0"
                                                                       data-toggle="switch" data-price="0"
                                                                       data-title="Select Your option"/>-->

                                                            </div>


                                                        </div>
                                                        <!--<div class="col-md-12">
                                                                    <p>
                                                                        <label>Auswählen</label>
                                                                        <br/>
                                                                        <input type="checkbox" data-group="default-price" class=""   data-operation="+" data-originaltitle="Select Your option" data-itemid="13" data-prodid="0"  data-toggle="switch"  data-price="0" data-title="Select Your option" />
                                                                    </p>
                                                        </div>-->

                                                        <div class="col-md-12" style="margin-top: 30px">
                                                            <div class="col-md-8">
                                                                <p class="big-head" style="font-weight: bold;font-size: 16px; text-align: left; margin-top: 10px;">BrillenLust-Preise
                                                                    (optional)  </p></div>
                                                            <div class="col-md-4">
                                                                <div  style="margin-top: 40px" class="selectable" data-reduc="0" data-reducqt=""
                                                                      data-operation="+" data-itemid="156" data-prodid="0"
                                                                      data-title="Click to exclude all" data-toggle="tooltip"
                                                                      step="7"
                                                                      title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                                      data-placement="bottom" data-price="0"><img
                                                                        data-tint="false" src="" alt=""
                                                                        class="img"/><span
                                                                        class="palette-clouds fui-cross icon_select"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <p style="font-size: 12px; text-align: left">Lorem ipsum dolor sit amet, consetetur
                                                                sadipscing elitr, sed diam nonumy eirmod
                                                                tempor invidunt ut labore et dolore magna
                                                                aliquyam erat.</p>


                                                            <div class="row-fluid">
                                                                <div class="col-md-6">
                                                                    <div class="row-fluid">
                                                                        <div class="col-md-12">
                                                                            <p class="big-head" style="font-weight: bold;font-size: 16px; text-align: left">Laufzeit</p>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">
                                                                                <input type="text" data-itemid="18"
                                                                                       style="width: 90%"
                                                                                       placeholder="ZAHL"
                                                                                       class="form-control"
                                                                                       data-title="Month"
                                                                                       data-originaltitle="Month"/>


                                                                                <!--<input type="text" data-itemid="18" class="form-control" data-required="true" data-title="Month" data-originaltitle="Month" />
                                                                                <p class="itemDes"
                                                                                      style="margin: 0 auto; max-width: 90%;">
                                                                                    Margin on price</p>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <p style="font-size: 12px; text-align: left; font-weight: bold; margin-top: 10px">Monate</p>
                                                                        </div>
                                                                        <div class="col-md-12">
                                                                            <p class="big-head" style="font-weight: bold;font-size: 16px; text-align: left">Agio</p>
                                                                        </div>
                                                                        <div class="col-md-8">
                                                                            <div class="form-group">

                                                                                <input type="text" data-itemid="19"
                                                                                       style="width: 90%"
                                                                                       placeholder="ZAHL"
                                                                                       class="form-control"
                                                                                       data-title="Percentage"
                                                                                       data-originaltitle="Percentage"/>

                                                                                <!--<p class="itemDes"
                                                                                   style="margin: 0 auto; max-width: 90%; text-align: center; font-size: 12px">
                                                                                    Margin on Price</p>-->
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <p style="font-weight: bold;font-size: 12px; text-align: left; margin-top: 10px">Prozent</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p style="font-weight: bold;font-size: 16px; text-align: left">
                                                                        Preisanzeige
                                                                    </p>
                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p style="font-size: 12px; text-align: left">Gerundet</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div  style="margin-top: 40px" class="selectable checked" data-reduc="0" data-reducqt=""
                                                                                  data-operation="+" data-itemid="15" data-prodid="0"
                                                                                  data-title="Click to exclude all"  data-group="round-unround-price"
                                                                                  step="2"
                                                                                  title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                                                  data-placement="bottom" data-price="0"><img
                                                                                    data-tint="false" src="" alt=""
                                                                                    class="img"/><span
                                                                                    class="palette-clouds fui-check icon_select"></span>
                                                                            </div>
                                                                            <!--<input type="checkbox"
                                                                                   data-group="round-unround-price"
                                                                                   class="prechecked"
                                                                                   checked
                                                                                   class="" data-operation="+"
                                                                                   data-originaltitle="rounded"
                                                                                   data-itemid="15" data-prodid="0"
                                                                                   data-toggle="switch" data-price="0"
                                                                                   data-title="Unrounded"/>-->

                                                                        </div>
                                                                    </div>

                                                                    <div class="col-md-12">
                                                                        <div class="col-md-8">
                                                                            <p style="font-size: 12px; text-align: left">Ungerundet</p>
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <div  style="margin-top: 40px" class="selectable" data-reduc="0" data-reducqt=""
                                                                                  data-operation="+" data-itemid="12" data-prodid="0"
                                                                                  data-title="Click to exclude all"  data-group="round-unround-price"
                                                                                  step="2"
                                                                                  title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                                                  data-placement="bottom" data-price="0"><img
                                                                                    data-tint="false" src="" alt=""
                                                                                    class="img"/><span
                                                                                    class="palette-clouds fui-cross icon_select"></span>
                                                                            </div>
                                                                            <!--<input type="checkbox"
                                                                                   data-group="round-unround-price"
                                                                                   class="" data-operation="+"
                                                                                   data-originaltitle="Unrounded"
                                                                                   data-itemid="15" data-prodid="0"
                                                                                   data-toggle="switch" data-price="0"
                                                                                   data-title="Unrounded"/>-->
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>





                                                    </div>



                                                </div>

                                                <div class="col-md-4 col-md-offset-1">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <p class="sub-head" style="text-align:  left; font-size: 16px;font-weight: bold">Upload SF-6 Datensatz</p>
                                                            <p style="text-align:  left; font-size: 12px">Hinweis:<br/>
                                                                Hier können Sie einen bearbeiteten Datensatz mit Ihren
                                                                selbst kalkulierten Preisen hochladen.
                                                                Die Software „Elektronische Preisliste“ zum Kalkulieren
                                                                Ihrer Preise finden Sie
                                                                HIER.
                                                                Wählen Sie hier die zip-Datei mit Ihren individuellen
                                                                Verkaufspreisen aus. </p>
                                                            <input type="file" data-itemid="16"
                                                                   class="form-control" data-required="true"
                                                                   placeholder="Keine Datei ausgewählt"
                                                                   data-title="SF6 Database"
                                                                   data-originaltitle="SF6 Database"/>

                                                            <!--<p class="itemDes"
                                                               style="margin: 0 auto; max-width: 90%; text-align: center; font-size: 12px">SF-6
                                                                Datenbank Importieren</p>-->
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p style="text-align:  left;font-size: 16px; font-weight: bold">
                                                            Import bestehende Konfiguration</p>

                                                        <p style="text-align:  left; font-size: 12px">Wenn Sie bereits eine individuelle Preisliste
                                                            konfiguriert haben, können Sie die gespeicherte
                                                            Konfigurationsdatei
                                                            hier erneut einspielen.</p>

                                                        <br/>
                                                        <input type="file" data-itemid="17"
                                                               class="form-control" data-required="true"
                                                               data-title="Select Your Old Pricelist"
                                                               data-originaltitle="Select Your Old Pricelist"/>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center">
                                            <a href="javascript:" class="btn btn-wide btn-primary btn-next" style="margin-right: 178px !important">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>
                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="3"
                                         data-title="Product Selection"
                                         data-dependitem="0">
                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Einstärkengläser</h2>

                                            <div class="genContent container-fluid">
                                                <p style="font-size: 14px; text-align: left">Rodenstock Einstärkengläser Wählen Sie die Produkte
                                                    ab, die auf Ihrer individuellen Preisliste nicht
                                                    erscheinen sollen.</p>

                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category grey">
                                                            <label>Impression Mono Plus 2</label>
                                                            <br/>
                                                            <input type="checkbox" class="prechecked"
                                                                   checked
                                                                   data-operation="+"
                                                                   data-originaltitle="Pricing Mono Plus 2"
                                                                   data-itemid="20" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Pricing Mono Plus 2"/>

                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Impression Mono 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Pricing  Mono 2"
                                                                   data-itemid="21" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Pricing  Mono 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>Multigressiv Mono Plus 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Multigressiv Mono Plus 2"
                                                                   data-itemid="22" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Multigressiv Mono Plus 2"/>
                                                        </div>
                                                        <div class="sub-category orange">
                                                            <label>Multigressiv Mono 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Multigressiv Mono 2"
                                                                   data-itemid="23" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Multigressiv Mono 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category green">
                                                            <label>Cosmolit</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Cosmolit"
                                                                   data-itemid="24" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Cosmolit"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Perfalit</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfalit"
                                                                   data-itemid="25" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfalit"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Cosmolit Stock Line</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Cosmolit Stock Line"
                                                                   data-itemid="26" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Cosmolit Stock Line"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Perfalit Stock Line</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfalit Stock Line"
                                                                   data-itemid="28" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfalit Stock Line"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="4"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Nahkomfortgläser</h2>

                                            <div class="genContent container-fluid">
                                                <p style="font-size: 14px; text-align: left">Rodenstock Einstärkengläser Wählen Sie die Produkte
                                                    ab, die auf Ihrer individuellen Preisliste nicht
                                                    erscheinen sollen.</p>
                                                <div class="row-fluid">
                                                    <div class="col-md-3 ">
                                                        <div class="sub-category blue">
                                                            <label>Impression Ergo FS 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression Ergo FS 2"
                                                                   data-itemid="29" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression Ergo FS 2"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Impression Ergo 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression Ergo 2"
                                                                   data-itemid="30" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression Ergo 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>Multigressiv Ergo 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Multigressiv Ergo 2"
                                                                   data-itemid="31" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Multigressiv Ergo 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">


                                                        <div class="sub-category green">
                                                            <label>Progressiv Ergo </label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Progressiv Ergo "
                                                                   data-itemid="32" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Progressiv Ergo "/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="5"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Gleitsichtgläser</h2>

                                            <div class="genContent container-fluid">
                                                <p style="font-size: 14px; text-align: left">Rodenstock Einstärkengläser Wählen Sie die Produkte
                                                    ab, die auf Ihrer individuellen Preisliste nicht
                                                    erscheinen sollen.</p>
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category blue">
                                                            <label>Impression FreeSign 3</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression FreeSign 3"
                                                                   data-itemid="33" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression FreeSign 3"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Impression 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression 2"
                                                                   data-itemid="34" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression 2"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>Multigressiv MyView 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Multigressiv MyView 2"
                                                                   data-itemid="35" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Multigressiv MyView 2"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category green">
                                                            <label>Progressiv PureLife Free 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Progressiv PureLife Free 2"
                                                                   data-itemid="36" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Progressiv PureLife Free 2"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Progressiv Life Free</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Progressiv Life Free"
                                                                   data-itemid="37" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Progressiv Life Free"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>
                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="6"
                                         data-title="Product Selection"
                                         data-dependitem="0">
                                        <div class="clearStep">
                                            <h2 class="stepTitle">RodendStock Mehrstärkengläser</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category blue">
                                                            <label>Cosmolit Bifolit</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Cosmolit Bifolit"
                                                                   data-itemid="38" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Cosmolit Bifolit"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>C28 AS</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="C28 AS"
                                                                   data-itemid="39" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="C28 AS"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Grandalit C28</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Grandalit C28"
                                                                   data-itemid="40" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Grandalit C28"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Dufolit S28</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Dufolit S28"
                                                                   data-itemid="41" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Dufolit S28"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Bifolit C26</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Bifolit C26"
                                                                   data-itemid="42" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Bifolit C26"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="sub-category green">
                                                            <label>Trifolit C828</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Trifolit C828"
                                                                   data-itemid="43" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Trifolit C828"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="extra-action container-fluid">
                                            <div class="row-fluid">
                                                <div class="col-md-2">Ganze Kategorie deaktivieren</div>
                                                <div class="col-md-1">
                                                    <div class="selectable " data-reduc="0" data-reducqt=""
                                                         data-operation="+" data-itemid="151" data-prodid="0"
                                                         data-title="Click to exclude all" data-toggle="tooltip"
                                                         step="7"
                                                         title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                         data-placement="bottom" data-price="0"><img
                                                            data-tint="false" src="" alt=""
                                                            class="img"/><span
                                                            class="palette-clouds fui-cross icon_select"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>
                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="7"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Mineralgläser</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category blue">
                                                            <label>Impression 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression 2"
                                                                   data-itemid="44" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression 2"/>
                                                        </div>
                                                        <div class="sub-category blue">
                                                            <label>Multigressive My View 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Multigressive My View 2"
                                                                   data-itemid="47" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Multigressive My View 2"/>
                                                        </div>
                                                        <div class="sub-category blue">
                                                            <label>Progessive Pure Life</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Progessive Pure Life"
                                                                   data-itemid="50" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Progessive Pure Life"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>Cosmolux</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Cosmolux"
                                                                   data-itemid="45" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Cosmolux"/>
                                                        </div>
                                                        <div class="sub-category orange">
                                                            <label>Perfalux</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfalux"
                                                                   data-itemid="48" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfalux"/>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category green">
                                                            <label>Grandalux C28</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Grandalux C28"
                                                                   data-itemid="46" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Grandalux C28"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Grandsin C26</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Grandsin C26"
                                                                   data-itemid="49" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Grandsin C26"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Trilentar C728</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Trilentar C728"
                                                                   data-itemid="51" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Trilentar C728"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class=" extra-action container-fluid">
                                            <div class="row-fluid">
                                                <div class="col-md-12">
                                                    <span style="font-weight: bold; text-align: left">Hinweis:</span><br/>
                                                    Alle mineralischen Rodenstock Brillengläser werden separat auf einer Seite
                                                    zusammengefasst.
                                                </div>
                                            </div>
                                            <div class="row-fluid" style="margin-top: 10px">
                                                <div class="col-md-2">Ganze Kategorie deaktivieren</div>
                                                <div class="col-md-9">
                                                    <div class="selectable " data-reduc="0" data-reducqt=""
                                                         data-operation="+" data-itemid="152" data-prodid="0"
                                                         data-title="Click to exclude all" data-toggle="tooltip"
                                                         step="7"
                                                         title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                         data-placement="bottom" data-price="0"><img
                                                            data-tint="false" src="" alt=""
                                                            class="img"/><span
                                                            class="palette-clouds fui-cross icon_select"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px; clear: both" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="8"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Manufaktur
                                                Kunststoffgläser</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category blue">
                                                            <label>Perfastar 1.50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfastar 1.50"
                                                                   data-itemid="52" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfastar 1.50"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Starlenti 1:50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Starlenti 1:50"
                                                                   data-itemid="54" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Starlenti 1:50"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Formlenti Plan 1:50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Formlenti Plan 1:50"
                                                                   data-itemid="56" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Formlenti Plan 1:50"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3"><div class="sub-category orange">
                                                            <label>Exceltitas 1:50(C40)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Exceltitas 1:50(C40)"
                                                                   data-itemid="53" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Exceltitas 1:50(C40)"/>
                                                        </div>
                                                        <div class="sub-category orange">
                                                            <label>Datalit Bifo 1:50(C40)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Datalit Bifo 1:50(C40)"
                                                                   data-itemid="55" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Datalit Bifo 1:50(C40)"/>
                                                        </div>
                                                        <div class="sub-category orange">
                                                            <label>Perfastar Bifo 1:50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfastar Bifo 1:50"
                                                                   data-itemid="57" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfastar Bifo 1:50"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="extra-action container-fluid">

                                            <div class="row-fluid">
                                                <div class="col-md-2">Ganze Kategorie deaktivieren</div>
                                                <div class="col-md-1">
                                                    <div class="selectable " data-reduc="0" data-reducqt=""
                                                         data-operation="+" data-itemid="153" data-prodid="0"
                                                         data-title="Click to exclude all" data-toggle="tooltip"
                                                         step="8"
                                                         title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                         data-placement="bottom" data-price="0"><img
                                                            data-tint="false" src="" alt=""
                                                            class="img"/><span
                                                            class="palette-clouds fui-cross icon_select"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="9"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodentock Manufaktur Mineralgläser</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <div class="sub-category blue">
                                                            <label>Formlenti plan(Perfalux 1.50 /
                                                                1.70)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Forlwmti Plan(Perfalux 1.50 / 1.70)"
                                                                   data-itemid="58" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Forlwmti Plan(Perfalux 1.50 / 1.70)"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Lenti 1.50 / 1.70(konkav)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Lemti 1.50 / 1.70(ConCave)"
                                                                   data-itemid="61" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Lemti 1.50 / 1.70(ConCave)"/>
                                                        </div>

                                                        <div class="sub-category blue">
                                                            <label>Biglas</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Biglas"
                                                                   data-itemid="64" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Biglas"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category orange">
                                                            <label>Plankonvex(1.50 / 1.70)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plano(1.50 / 1.70)"
                                                                   data-itemid="59" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plano(1.50 / 1.70)"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Lentilux 1.70</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Lentilux 1.70"
                                                                   data-itemid="62" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Lentilux 1.70"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category green">
                                                            <label>Ardis 1:50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Ardis 1:50"
                                                                   data-itemid="60" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Ardis 1:50"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Ardis</label>
                                                            <br/>
                                                            <input type="checkbox" class="prechecked"
                                                                   checked
                                                                   data-operation="+"
                                                                   data-originaltitle="Ardis"
                                                                   data-itemid="63" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Ardis"/>

                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Lenti konkav</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Lenti Concove"
                                                                   data-itemid="65" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Lenti Concove"/>
                                                        </div>

                                                        <div class="sub-category green">
                                                            <label>Excellent 1:50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Excellent 1:50"
                                                                   data-itemid="66" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Excellent 1:50"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="extra-action container-fluid">
                                            <div class="row-fluid">
                                                <div class="col-md-12">
                                                    <span style="font-weight: bold; text-align: left">Hinweis:</span><br/>
                                                    Alle mineralischen Rodenstock Brillengläser werden separat auf einer Seite
                                                    zusammengefasst.
                                                </div>
                                            </div>
                                            <div class="row-fluid"  style="margin-top: 10px">
                                                <div class="col-md-2">Ganze Kategorie deaktivieren</div>
                                                <div class="col-md-1">
                                                    <div class="selectable " data-reduc="0" data-reducqt=""
                                                         data-operation="+" data-itemid="154" data-prodid="0"
                                                         data-title="Click to exclude all" data-toggle="tooltip"
                                                         step="9"
                                                         title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                         data-placement="bottom" data-price="0"><img
                                                            data-tint="false" src="" alt=""
                                                            class="img"/><span
                                                            class="palette-clouds fui-cross icon_select"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="10"
                                         data-title="Product Selection"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Rodenstock Sport & Fashion</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <p style="font-size: 14px; font-weight:bold">Einstärkengläser</p>
                                                        <div class="sub-category red">
                                                            <label>Impresssion Mono(Sports 2)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impresssion Mono(Sports 2)"
                                                                   data-itemid="67" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impresssion Mono(Sports 2)"/>
                                                        </div>

                                                        <div class="sub-category red">
                                                            <label>Perfalit Sports 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfalit Sports 2"
                                                                   data-itemid="69" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfalit Sports 2"/>
                                                        </div>

                                                        <div class="sub-category red">
                                                            <label>Perfalit Sport</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Perfalit Sport"
                                                                   data-itemid="70" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Perfalit Sport"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <p style="font-size: 14px; font-weight:bold">Gleitsichtgläser</p>
                                                        <div class="sub-category red">
                                                            <label>Impression(Fashion Curved 2)</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression(Fashion Curved 2)"
                                                                   data-itemid="68" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression(Fashion Curved 2)"/>
                                                        </div>

                                                        <div class="sub-category red">
                                                            <label>Impression Sport 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Impression Sport 2"
                                                                   data-itemid="157" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Impression Sport 2"/>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="extra-action container-fluid">

                                            <div class="row-fluid">
                                                <div class="col-md-2">Ganze Kategorie deaktivieren</div>
                                                <div class="col-md-1">
                                                    <div class="selectable " data-reduc="0" data-reducqt=""
                                                         data-operation="+" data-itemid="155" data-prodid="0"
                                                         data-title="Click to exclude all" data-toggle="tooltip"
                                                         step="7"
                                                         title="Click to exclude all" data-originaltitle="Click to exclude all"
                                                         data-placement="bottom" data-price="0"><img
                                                            data-tint="false" src="" alt=""
                                                            class="img"/><span
                                                            class="palette-clouds fui-cross icon_select"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="11"
                                         data-title="NetLine products"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Netline Produkte</h2>

                                            <div class="genContent container-fluid">


                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <p class="">Glastypen</p>
                                                        <div class="sub-category netline">
                                                            <label>Kunststoff- Lagergläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plastic Available Glasses"
                                                                   data-itemid="71" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plastic Available Glasses"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Kunststoff Einstärkengläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plastic Single Vision"
                                                                   data-itemid="72" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plastic Single Vision"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Mineral Einstärkengläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Mineral Single Vision"
                                                                   data-itemid="73" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Mineral Single Vision"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Gleitsichtgläser Freiform</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Progressive Freeform"
                                                                   data-itemid="74" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Progressive Freeform"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Kunststoff Gleitsichtgläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plastic Progressive"
                                                                   data-itemid="75" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plastic Progressive"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Mineral Gleitsichtgläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Mineral Progressive"
                                                                   data-itemid="76" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Mineral Progressive"/>
                                                        </div>
                                                        <div class="sub-category netline">
                                                            <label>Kunststoff Nahgläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plastic Near-vision Lenses"
                                                                   data-itemid="77" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plastic Near-vision Lenses"/>
                                                        </div>

                                                        <div class="sub-category netline">
                                                            <label>Kunststoff Bifokalgläser</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Plastic Bifocal"
                                                                   data-itemid="78" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Plastic Bifocal"/>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-3">
                                                        <p class="">Beschichtungen</p>
                                                        <div class="sub-category orange">
                                                            <label>Hard Super -A R+</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Hard Super -A R+"
                                                                   data-itemid="80" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Hard Super -A R+"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Super Hard -A R</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Super Hard -A R"
                                                                   data-itemid="81" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Super Hard -A R"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Super -A R</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Super -A R"
                                                                   data-itemid="82" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Super -A R"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>Simple -A R</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Simple -A R"
                                                                   data-itemid="83" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Simple -A R"/>
                                                        </div>

                                                        <div class="sub-category orange">
                                                            <label>unvergu?tet</label>
                                                            <br/>
                                                            <input type="checkbox" class="prechecked"
                                                                   checked
                                                                   data-operation="+"
                                                                   data-originaltitle="Untempered"
                                                                   data-itemid="84" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Untempered"/>
                                                        </div>

                                                    </div>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>

                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="12"
                                         data-title="NetLine products"
                                         data-dependitem="0">
                                        <div class="clearStep">
                                            <h2 class="stepTitle">Beschichtungen</h2>

                                            <div class="genContent container">
                                                <div class="row">
                                                    <div class="col-md-1">
                                                        <p style="margin-top: 10px; font-size: 12px; font-weight: bold; text-align: left">DNEye</p>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="sub-category grey">
                                                            <label>Inklusive</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Balance 2"
                                                                   data-itemid="85" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Balance 2"/>
                                                        </div>
                                                        <!--<input type="text" class="form-control"
                                                               data-operation="+"
                                                               data-originaltitle="DNEye"
                                                               data-itemid="85" data-prodid="0"
                                                               data-price="0"
                                                               data-title="DNEye"/>-->

                                                    </div>

                                                </div>

                                                <div class="row" style="margin-top: 10px">
                                                    <div class="col-md-1">
                                                        <p style="margin-top: 10px; font-size: 12px; font-weight: bold; text-align: left">Insurance</p>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <div class="sub-category grey">
                                                            <label>Exklusive</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Balance 2"
                                                                   data-itemid="86" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Balance 2"/>
                                                        </div>
                                                        <!--<input type="text" class="form-control"
                                                               data-operation="+"
                                                               data-originaltitle="Insurance"
                                                               data-itemid="86" data-prodid="0"
                                                                 data-price="0"
                                                               data-title="Insurance"/>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">NÄCHSTER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>
                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="13"
                                         data-title="NetLine products"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Kunststoffgläser.</h2>

                                            <div class="genContent container">
                                                <p style="display: block; clear: both; font-size: 14px;text-align: left">Wählen Sie hier aus, welche Positionen auf den
                                                    Preisblättern generell angezeigt werden sollen.</p>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p style="font-size: 14px; font-weight: bold">Beschichtungen</p>
                                                        <div class="sub-category grey">
                                                            <label>Solitaire Protect Balance 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Balance 2"
                                                                   data-itemid="87" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Balance 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire Protect Plus 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Plus 2"
                                                                   data-itemid="88" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Plus 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire Protect Sun 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Sun 2"
                                                                   data-itemid="89" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Sun 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire Protect Sun 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Sun 2"
                                                                   data-itemid="90" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Sun 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire Protect 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect 2"
                                                                   data-itemid="91" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect 2"/>
                                                        </div>


                                                        <div class="sub-category grey">
                                                            <label>Solitaire Eco 2</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Eco 2"
                                                                   data-itemid="92" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Eco 2"/>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <p class="" style="font-size: 14px; font-weight: bold">ColorMatic IQ</p>

                                                        <div class="sub-category grey">
                                                            <label>Index 1.67</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Index 1.67"
                                                                   data-itemid="87" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Index 1.67"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Index 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Index 1.60"
                                                                   data-itemid="88" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Index 1.60"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>ColorMatic IQ Sun 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="ColorMatic IQ Sun 1.60"
                                                                   data-itemid="89" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="ColorMatic IQ Sun 1.60"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Index 1.54</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="ColorMatic IQ Sun 1.60"
                                                                   data-itemid="150" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="ColorMatic IQ Sun 1.60"/>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <p class="">Verspiegelungen</p>
                                                        <div class="sub-category grey">
                                                            <label>Mirror inkl. Solitaire Back 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Mirror inkl. Solitaire Back 1.60"
                                                                   data-itemid="90" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Mirror inkl. Solitaire Back 1.60"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire SilverMoon 1.67</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire SilverMoon 1.67"
                                                                   data-itemid="91" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire SilverMoon 1.67"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Solitaire SilverMoon 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire SilverMoon"
                                                                   data-itemid="92" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire
SilverMoon"/>
                                                        </div>


                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <p class="" style="font-size: 14px; font-weight: bold">Farben</p>

                                                        <div class="sub-category grey">
                                                            <label>SunContrast, Skyline, Spezial</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="SunContrast, Skyline, Spezia"
                                                                   data-itemid="93" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="SunContrast, Skyline, Spezia"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Filter, Uni, Graduell, Pastella</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Filter, Uni, Graduell, Pastella"
                                                                   data-itemid="94" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Filter, Uni, Graduell,
Pastella"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Polarized 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Polarized 1.60"
                                                                   data-itemid="95" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Polarized 1.60"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Polarized 1.60</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Polarized 1.60"
                                                                   data-itemid="95" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Polarized 1.60"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Polarized 1.50</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Polarized 1.50"
                                                                   data-itemid="96" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Polarized 1.50"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Aufpreis Sonderfarbe</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Aufpreis"
                                                                   data-itemid="97" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Aufpreis"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p style="font-weight: bold; font-size: 14px">Zusatzleistungen</p>
                                                        <div class="sub-category grey">
                                                            <label>DNEye inkl. Personal EyeModel</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="DNEye inkl. Personal EyeModel"
                                                                   data-itemid="98" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="DNEye inkl. Personal EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Personal EyeModel</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Personal EyeModel"
                                                                   data-itemid="99" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Personal EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>EyeModel</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="EyeModel"
                                                                   data-itemid="100" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Prismen</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Prismen"
                                                                   data-itemid="101" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Prismen"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>MDM</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="MDM"
                                                                   data-itemid="102" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="MDM"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Versicherung</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Versicherung"
                                                                   data-itemid="103" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Versicherung"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Höhere Zylinderwirkung</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Versicherung"
                                                                   data-itemid="104" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Versicherung"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Abweichende Kurve / Dicke</label>
                                                            <br/>
                                                            <input type="checkbox" class="" data-operation="+"
                                                                   data-originaltitle="Versicherung"
                                                                   data-itemid="104" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Versicherung"/>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>

                                        </div>


                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>


                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="14"
                                         data-title="NetLine products"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Mineralgläser..<span
                                                    style="display: block; clear: both; font-size: 14px">Wählen Sie hier aus, welche Positionen auf den Preisblättern generell angezeigt werden sollen.</span>
                                            </h2>


                                            <div class="genContent container-fluid">


                                                <div class="row-fluid">
                                                    <div class="col-md-3">
                                                        <p>Beschichtungen</p>
                                                        <div class="sub-category grey">
                                                            <label>Supersin</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Balance 2"
                                                                   data-itemid="87" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Balance 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Multisin</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Plus 2"
                                                                   data-itemid="88" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Plus 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Perfasin</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Sun 2"
                                                                   data-itemid="89" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Sun 2"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>unbeschichtet</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Solitaire Protect Sun 2"
                                                                   data-itemid="90" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Solitaire Protect Sun 2"/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-3">
                                                        <p class="">Farben</p>
                                                        <div class="sub-category grey">
                                                            <label>Colormatic</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="SunContrast, Skyline, Spezia"
                                                                   data-itemid="93" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="SunContrast, Skyline, Spezia"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Brunal</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Filter, Uni, Graduell, Pastella"
                                                                   data-itemid="94" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Filter, Uni, Graduell,
Pastella"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Color</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Polarized 1.60"
                                                                   data-itemid="95" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Polarized 1.60"/>
                                                        </div>


                                                        <div class="sub-category grey">
                                                            <label>Colorsin Super</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Polarized 1.50"
                                                                   data-itemid="96" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Polarized 1.50"/>
                                                        </div>

                                                    </div>

                                                    <div class="col-md-3">
                                                        <p class="stepTitle">Zusatzleistungen</p>

                                                        <div class="sub-category grey">
                                                            <label>DNEye inkl. Personal EyeModel</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="DNEye inkl. Personal EyeModel"
                                                                   data-itemid="98" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="DNEye inkl. Personal EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Personal EyeModel</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Personal EyeModel"
                                                                   data-itemid="99" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Personal EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Prismen</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="EyeModel"
                                                                   data-itemid="100" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="EyeModel"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>MDM</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="MDM"
                                                                   data-itemid="102" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="MDM"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Versicherung</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Versicherung"
                                                                   data-itemid="103" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Versicherung"/>
                                                        </div>

                                                        <div class="sub-category grey">
                                                            <label>Höhere Zylinderwirkung</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Versicherung"
                                                                   data-itemid="104" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Versicherung"/>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>


                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="15"
                                         data-title="Seitenbearbeitung" data-required="false"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Seitenfolge</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-12">
                                                        <p style="font-size: 14px; text-align: left">
                                                            Bitte wählen Sie XX Füllseiten zur
                                                            Vervollständigung Ihrer individuellen
                                                            Kurzpreisliste Brillengläse.
                                                        </p>
                                                        <ul class="draggable" id="sortable">
                                                            <li class="draggable-section ui-state-default ui-state-disabled">
                                                                <h4>Motive 1</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 2</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 3</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 4</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 5</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 6</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 7</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 8</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 9</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 10</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 11</h4></li>
                                                            <li class="draggable-section ui-state-default ui-state-disabled">
                                                                <h4>Motive 12</h4></li>
                                                        </ul>

                                                        <a href="javascript;" class="addmore_slide">Add More Slide</a>


                                                    </div>


                                                </div>

                                            </div>
                                        </div>


                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>


                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="16"
                                         data-title="Seitenbearbeitung" data-required="false"
                                         data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Seitenfolge</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">

                                                    <div class="col-md-12">
                                                        <p>
                                                        <p>Bitte wählen Sie XX Füllseiten zur
                                                            Vervollständigung Ihrer individuellen
                                                            Kurzpreisliste
                                                            Brillengläser.</p>
                                                        </p>

                                                        <ul class="draggable" id="sortable2">
                                                            <li class="draggable-section ui-state-default ui-state-disabled">
                                                                <h4>Motive 1</h4></li>
                                                            <li class="draggable-section ui-state-default ui-state-disabled">
                                                                <h4>Motive 2</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 3</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 4</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 5</h4></li>
                                                            <li class="draggable-section ui-state-default">
                                                                <h4>Motive 6</h4></li>
                                                        </ul>


                                                    </div>


                                                </div>

                                            </div>
                                        </div>


                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary  linkPrevious">Züruck</a>
                                        </p>


                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="17"
                                         data-title="Vorschau" data-required="false" data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Vorschau</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-12">
                                                        <p>
                                                        <p>Bitte kontrollieren Sie Ihre individuelle
                                                            Kurzpreisliste auf ihre
                                                            Richtigkeit. </p>
                                                        <br/>

                                                        <div class="preview-pdf">
                                                            <img class="img-responsive"
                                                                 src="{{ asset('images/pdf-preview.png') }}"/>
                                                        </div>
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <div class="errorMsg alert alert-danger">Menüpunkt auszuwählen, um
                                            fortzufahren
                                        </div>
                                        <p style="margin-top: 42px;" class="text-center"><a
                                                href="javascript:"
                                                class="btn btn-wide btn-primary btn-next">WEITER</a>
                                            <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                        </p>


                                    </div>

                                    <div class="genSlide" data-start="0" data-stepid="18"
                                         data-title="PDF-Export" data-required="false" data-dependitem="0">

                                        <div class="clearStep">
                                            <h2 class="stepTitle">Vorschau</h2>

                                            <div class="genContent container-fluid">
                                                <div class="row-fluid">
                                                    <div class="col-md-12">
                                                        <p>
                                                            <label>Speichern Sie Ihre individuelle
                                                                Kurzpreisliste Brillengläser auf Ihrem
                                                                Computer ab. </label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Export to your computer "
                                                                   data-itemid="106" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Export to your computer"/>

                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row-fluid">
                                                    <div class="col-md-12">
                                                        <p>
                                                            <label>Speichern Sie Ihre individuelle
                                                                Kurzpreisliste Brillengläser auf Ihrem
                                                                Computer ab. </label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Save configuration to your computer"
                                                                   data-itemid="107" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Export to your computer"/>

                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="row-fluid">
                                                    <div class="col-md-12">
                                                        <p>
                                                            <label>Bestellen Sie hier Ihre individuelle
                                                                Kurzpreisliste Brillengläser hochwertig
                                                                gedruckt
                                                                und verarbeitet.
                                                                Die
                                                                Preislisten werden innerhalb von XX
                                                                Werktagen produziert und von FIRMA Michael
                                                                Hirschel GMBH an
                                                                die von Ihnen in den Stammdaten hinterlegte
                                                                Adresse
                                                                versendet. Nach der Bestellung
                                                                erhalten Sie eine Auftragsbestätigung an die
                                                                von Ihnen hinterlegte Mailadresse.
                                                                Ich
                                                                bestelle
                                                                verbindlich
                                                                Exemplare meiner individuellen
                                                                Kurzpreisliste
                                                                Brillenglas zum Preis von je 6
                                                                Euro pro Exemplar zzgl.
                                                                12 Euro Verpackung und
                                                                Versand.</label>
                                                            <br/>
                                                            <input type="checkbox" class=""
                                                                   data-operation="+"
                                                                   data-originaltitle="Save configuration to your computer"
                                                                   data-itemid="108" data-prodid="0"
                                                                   data-toggle="switch" data-price="0"
                                                                   data-title="Export to your computer"/>
                                                            Ich wünsche eine abweichende Lieferadresse.

                                                    </div>
                                                </div>


                                                <div class="errorMsg alert alert-danger">Menüpunkt
                                                    auszuwählen, um fortzufahren
                                                </div>
                                                <p style="margin-top: 42px;" class="text-center"><a
                                                        href="javascript:"
                                                        class="btn btn-wide btn-primary btn-next">WEITER</a>
                                                    <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                                </p>


                                            </div>
                                        </div>
                                    </div>

                                    <div class="genSlide" id="finalSlide" data-stepid="final">
                                        <h2 class="stepTitle">Bestellung</h2>

                                        <div class="genContent">
                                            <div class="genContentSlide active">
                                                <p style="display: none">endgültige Preis : </p>

                                                <h3 id="finalPrice" style=""></h3>

                                                <p>
                                                <h4>Bestellzusammenfassung:</h4><br/>
                                                XX Exemplare individuelle Kurzpreisliste Brillenglas zum
                                                Preis von
                                                XXX inkl. Porto und Verpackung.
                                                </p>

                                                <div class="row-fluid">
                                                    <div class="col-md-6">
                                                        <h4>Billing info</h4>

                                                        <div class="form-group">
                                                            <label for="address_1" style="display: none">ADRESSE</label>
                                                            <input type="text" id="address_1"
                                                                   data-required="true"
                                                                   placeholder="Address 1"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="address_2" style="display: none">ADRESSE</label>
                                                            <input type="text" id="address_2"
                                                                   data-required="false"
                                                                   placeholder="Address 1"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="billing_postcode"
                                                                   style="display: none">PLZ</label>
                                                            <input type="text" id="billing_postcode"
                                                                   data-required="true"
                                                                   placeholder="Billing Postcode"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="billing_city"
                                                                   style="display: none">STADT</label>
                                                            <input type="text" id="billing_city"
                                                                   data-required="true"
                                                                   placeholder="Billing City"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="billing_country"
                                                                   style="display: none">LAND</label>
                                                            <input type="text" id="billing_country"
                                                                   data-required="true"
                                                                   placeholder="Country"
                                                                   class="form-control emailField "/>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <h4>Shipping info</h4>

                                                        <div class="form-group">
                                                            <label for="shipping_address1" style="display: none">ADRESSE</label>
                                                            <input type="text" id="shipping_address1"
                                                                   data-required="true"
                                                                   placeholder="Address 1"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="shipping_address2" style="display: none">ADRESSE</label>
                                                            <input type="text" id="shipping_address2"
                                                                   data-required="false"
                                                                   placeholder="Address 2"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="shipping_postcode"
                                                                   style="display: none">PLZ</label>
                                                            <input type="text" id="shipping_postcode"
                                                                   data-required="true"
                                                                   placeholder=" Postcode"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="shipping_city"
                                                                   style="display: none">STADT</label>
                                                            <input type="text" id="shipping_city"
                                                                   data-required="false" placeholder="City"
                                                                   class="form-control emailField "/>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="shipping_country"
                                                                   style="display: none">LAND</label>
                                                            <input type="text" id="shipping_country"
                                                                   data-required="false"
                                                                   placeholder="Enter your email"
                                                                   class="form-control emailField "/>
                                                        </div>
                                                    </div>

                                                </div>


                                                <p style="margin-bottom: 28px;"><a href="javascript:"
                                                                                   id="wpe_btnOrder"
                                                                                   class="btn btn-wide btn-primary">Complete</a>
                                                    <a href="javascript:" class="btn btn-wide btn-primary linkPrevious">Züruck</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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