<?php
/**
 * Textblock
 * Shortcode which creates a text element wrapped in a div
 */

if ( !class_exists( 'avia_sc_caorda_instructors_list' ) )
{
	class avia_sc_caorda_instructors_list extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Instructors List', 'avia_framework' );
				$this->config['tab']			= __('Content Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-image.png";
				$this->config['order']			= 100;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'caorda:instructors_list';
				$this->config['modal_data']     = array('modal_class' => 'mediumscreen');
				$this->config['tooltip'] 	    = __('Inserts a 3-column list of all instructors', 'avia_framework' );
			}

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			/*function popup_elements()
			{
				$this->elements = array(

					array(
							"name" 	=> __("Project Type",'avia_framework' ),
							"desc" 	=> __("Choose the type of project to display here",'avia_framework' ),
							"id" 	=> "project_type",
							"type" 	=> "select",
							"std" 	=> "all",
							"subtype" => array(
												__('All',  'avia_framework' ) =>'all',
												__('Community Enhancement',  'avia_framework' ) =>'community-enhancement',
												__('Environmental Planning',  'avia_framework' ) =>'environmental-planning',
												__('Public Engagement', 'avia_framework' ) =>'public-engagement',
												__('Program Management',  'avia_framework' ) =>'program-management',
												)
							),

					);						
						
						
						
			}*/

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
				$params['innerHtml'] .= "<h3>Instructors List</h3>";
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
				//extract(shortcode_atts(array('project_type'=>'all'), $atts, $this->config['shortcode']));

				$output = '<div class="instructors-list-container">';

				$instructors = new WP_Query(array(
					'post_type' => 'instructor',
					'posts_per_page' => -1,
					'orderby' => 'date',
					'order' => 'DESC'));
				$output .= '<ul class="instructors-list">';
				while ($instructors->have_posts()) : $instructors->the_post();
					$output .= '<li class="instructor">';
                    $output .= '<div class="instructor-container">';
                    if (has_post_thumbnail()) :
                        $output .= '<div class="instructor-image">';
                        $output .= get_the_post_thumbnail(get_the_ID(), 'full');
                        $output .= '</div>';
                    endif;
                    $output .= '<div class="instructor-name">';
                    $output .= get_the_title();
                    $output .= '</div>';
					$output .= '<div class="instructor-read-more">';
                    $output .= '<a href="'.get_the_permalink().'">Read More</a>';
					$output .= '</div>';
                    $output .= '</div>';
					$output .= '</li>';
				endwhile;
				$output .= '</ul>';
				$output .= '</div>';
				wp_reset_query();
				return $output;
			}
	}
}









