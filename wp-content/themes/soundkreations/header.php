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