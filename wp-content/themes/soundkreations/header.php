<?php
global $avia_config;

$style 		= $avia_config['box_class'];
$responsive	= avia_get_option('responsive_active') != "disabled" ? "responsive" : "fixed_layout";
$blank 		= isset($avia_config['template']) ? $avia_config['template'] : "";	
$av_lightbox= avia_get_option('lightbox_active') != "disabled" ? 'av-default-lightbox' : 'av-custom-lightbox';

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="<?php echo " html_{$style} ".$responsive." ".$av_lightbox." ".avia_header_class_string();?> ">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<!-- page title, displayed in your browser bar -->
<title><?php if(function_exists('avia_set_title_tag')) { echo avia_set_title_tag(); } ?></title>

<?php
/*
 * outputs a rel=follow or nofollow tag to circumvent google duplicate content for archives
 * located in framework/php/function-set-avia-frontend.php
 */
if (function_exists('avia_set_follow')) { echo avia_set_follow(); }


/*
 * outputs a favicon if defined
 */
if (function_exists('avia_favicon'))    { echo avia_favicon(avia_get_option('favicon')); }
?>


<!-- mobile setting -->
<?php

if( strpos($responsive, 'responsive') !== false ) echo '<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">';
?>


<!-- Scripts/CSS and wp_head hook -->

<?php
/* Always have wp_head() just before the closing </head>
 * tag of your theme, or you will break many plugins, which
 * generally use this hook to add elements to <head> such
 * as styles, scripts, and meta tags.
 */

wp_head();

?>

    <link rel='stylesheet' id='lfb-reset-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/reset.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-bootstrap-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/bootstrap.min.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-flat-ui-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/flat-ui_frontend.css?ver=9.195' type='text/css' media='all' />
    <link rel='stylesheet' id='lfb-estimationpopup-css'  href='<?php echo get_stylesheet_directory_uri() ?>/wpe/css/lfb_forms.css?ver=9.195' type='text/css' media='all' />


    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/bootstrap-switch.js?ver=9.195'></script>
    <script type='text/javascript'>

        /* <![CDATA[ */
        var wpe_forms = [{
            "currentRef": 0,
            "ajaxurl": "<?php bloginfo('siteurl') ?>/wp-admin/admin-ajax.php",
            "initialPrice": "0",
            "max_price": "0",
            "currency": "$",
            "currencyPosition": "left",
            "intro_enabled": "0",
            "save_to_cart": "0",
            "colorA": "#1abc9c",
            "close_url": "#",
            "animationsSpeed": "0.5",
            "email_toUser": "0",
            "showSteps": "1",
            "formID": "3",
            "gravityFormID": "0",
            "showInitialPrice": "0",
            "disableTipMobile": "0",
            "legalNoticeEnable": "0",
            "links": [{
                "id": "12",
                "formID": "3",
                "originID": "13",
                "destinationID": "14",
                "conditions": "[]"
            }, {
                "id": "13",
                "formID": "3",
                "originID": "14",
                "destinationID": "15",
                "conditions": "[]"
            }, {
                "id": "14",
                "formID": "3",
                "originID": "15",
                "destinationID": "16",
                "conditions": "[]"
            }, {"id": "15", "formID": "3", "originID": "16", "destinationID": "17", "conditions": "[]"}],
            "txt_yes": "Yes",
            "txt_no": "No"
        }];
        /* ]]> */
    </script>
    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/lfb_form.min.js?ver=9.195'></script>
    <script type='text/javascript' src='<?php echo get_stylesheet_directory_uri() ?>/wpe/js/lfb_frontend.min.js?ver=9.195'></script>


</head>




<body id="top" <?php body_class($style." ".$avia_config['font_stack']." ".$blank); avia_markup_helper(array('context' => 'body')); ?>>

	<div id='wrap_all'>

        <?php //if (get_field("page_notification_text", get_the_ID()) !== '' && get_field("page_notification_text", get_the_ID()) !== null) : ?>
        <!--<div class="notification local-notification">
            <?php //echo get_field("notification_text", get_the_ID()); ?>
        </div>-->
    <?php //else ?>

    <?php if (ot_get_option('global_notification') !== '') : ?>
        <div class="notification global-notification">
            <?php echo ot_get_option('global_notification'); ?>
        </div>
    <?php endif; ?>
	<?php 
	if(!$blank) //blank templates dont display header nor footer
	{ 
        //fetch the template file that holds the main menu, located in includes/helper-menu-main.php
        get_template_part( 'includes/helper', 'main-menu' );

	} ?>
	
	<div id='main' data-scroll-offset='<?php echo avia_header_setting('header_scroll_offset'); ?>'>
        <div id="build_your_program">
            <?php if (ot_get_option('build_your_program_page') !== '') : ?>
                <a href="<?php echo get_permalink(ot_get_option('build_your_program_page')); ?>">
                    <img src="<?php echo get_bloginfo('url')?>/wp-content/themes/soundkreations/img/btn_build_your_program.png" alt="Build your Program" />
                </a>
            <?php endif; ?>
        </div>
	<?php do_action('ava_after_main_container'); ?>