<?php
/**
 * Textblock
 * Shortcode which creates a text element wrapped in a div
 */

if ( !class_exists( 'avia_sc_caorda_multi_pager' ) )
{
	class avia_sc_caorda_multi_pager extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('3 Page Viewer', 'avia_framework' );
				$this->config['tab']			= __('Content Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-image.png";
				$this->config['order']			= 100;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'caorda:three_page_viewer';
				$this->config['modal_data']     = array('modal_class' => 'mediumscreen');
				$this->config['tooltip'] 	    = __('Creates a three-page item list.', 'avia_framework' );
			}

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements()
			{
				$this->elements = array(

					array(
							"name" 	=> __("Content (Section 1)",'avia_framework' ),
							"desc" 	=> __("Content for the first section",'avia_framework' ),
							"id" 	=> "content_1",
							"type" 	=> "textarea",
							"std" 	=> ""

					),array(
							"name" 	=> __("Icon (Section 1)",'avia_framework' ),
							"desc" 	=> __("Icon for the first section",'avia_framework' ),
							"id" 	=> "content_1_image",
							"type" 	=> "image"

					),array(
							"name" 	=> __("Content (Section 2)",'avia_framework' ),
							"desc" 	=> __("Content for the second section",'avia_framework' ),
							"id" 	=> "content_2",
							"type" 	=> "textarea",
							"std" 	=> ""

					),array(
							"name" 	=> __("Icon (Section 2)",'avia_framework' ),
							"desc" 	=> __("Icon for the second section",'avia_framework' ),
							"id" 	=> "content_2_image",
							"type" 	=> "image"

					),array(
							"name" 	=> __("Content (Section 3)",'avia_framework' ),
							"desc" 	=> __("Content for the third section",'avia_framework' ),
							"id" 	=> "content_3",
							"type" 	=> "textarea",
							"std" 	=> ""

					),array(
							"name" 	=> __("Icon (Section 3)",'avia_framework' ),
							"desc" 	=> __("Icon for the third section",'avia_framework' ),
							"id" 	=> "content_3_image",
							"type" 	=> "image"

					));						
						
						
						
			}

			/**
			 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
			 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
			 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
			 *
			 *
			 * @param array $params this array holds the default values for $content and $args.
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_element($params)
			{
				$template = $this->update_template("src", "<img src='{{src}}' alt=''/>");
				$img	  = "";
				
				if(!empty($params['args']['attachment']) && !empty($params['args']['attachment_size']))
				{
					$img = wp_get_attachment_image($params['args']['attachment'],$params['args']['attachment_size']);
				}
				else if(isset($params['args']['src']) && is_numeric($params['args']['src']))
				{
					$img = wp_get_attachment_image($params['args']['src'],'large');
				}
				else if(!empty($params['args']['src']))
				{
					$img = "<img src='".$params['args']['src']."' alt=''  />";
				}


				$params['innerHtml']  = "<div class='avia_image avia_image_style avia_hidden_bg_box'>";
				$params['innerHtml'] .= "<div ".$this->class_by_arguments('align' ,$params['args']).">";
				$params['innerHtml'] .= "<h3>Three-Page Viewer</h3>";
				$params['innerHtml'] .= "</div>";
				$params['innerHtml'] .= "</div>";
				$params['class'] = "";

				return $params;
			}

			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
                extract(shortcode_atts(array('content_1'=>'','content_2'=>'','content_3'=>'','content_1_image'=>'','content_2_image'=>'','content_3_image'=>''), $atts, $this->config['shortcode']));
                $icons = '<div class="pager-icons">';
                $outer_content = '';
                
				$output = '<div class="multi-pager">';
                if ($content_1 !== '') :
                    $icons .= '<div class="icon" data-for="page-1">';
                    $icons .= '<a style="background-image: url('.$content_1_image.');"></a>';
                    $icons .= '</div>';
                    $outer_content .= '<div class="page page-1">' . $content_1 . '</div>';
                endif;
                if ($content_2 !== '') :
                    $icons .= '<div class="icon" data-for="page-2">';
                    $icons .= '<a style="background-image: url('.$content_2_image.');"></a>';
                    $icons .= '</div>';
                    $outer_content .= '<div class="page page-2">' . $content_2 . '</div>';
                endif;
                if ($content_3 !== '') :
                    $icons .= '<div class="icon" data-for="page-3">';
                    $icons .= '<a style="background-image: url('.$content_3_image.');"></a>';
                    $icons .= '</div>';
                    $outer_content .= '<div class="page page-3">' . $content_3 . '</div>';
                endif;
                $icons .= '</div>';
				$output .= $icons . $outer_content;
				$output .= '</div>';
				
				return $output;
			}


	}
}









