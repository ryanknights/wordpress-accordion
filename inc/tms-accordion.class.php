<?php
	
	class TmsAccordion 
	{	
		private $panels;
		private $active;
		private $addScript;
		private $panelsCounter;

		/**
		 * Initialises the plugin by registering assets & adding the shortcodes
		 *
		 * @return void		 
		 */

		public function __construct ()
		{	
			$this->enqueueAssets();
			$this->addShortcodes();
			$this->addFilters();
		}

		/**
		 * Adds hooks for assets to be added
		 *
		 * @return void		 
		 */

		public function enqueueAssets ()
		{	
			add_action('wp_enqueue_scripts', array(&$this, 'registerScript'));
		}

		/**
		 * Adds filters for scripts and shortcode character removal
		 *
		 * @return void		 
		 */

		public function addFilters ()
		{
			add_action('wp_footer', array(&$this, 'printScript'));
			add_filter('the_content', array(&$this, 'removeChars'));
		}

		/**
		 * Register the JS Script
		 *
		 * @return void		 
		 */

		public function registerScript ()
		{
			wp_register_script('tms-accordion', plugin_dir_url(__FILE__) . 'assets/js/tms-accordion.min.js', array(), '1.0', true);
			wp_register_style('tms-accordion', plugin_dir_url(__FILE__) . 'assets/css/tms-accordion.css');
		}

		/**
		 * Prints the JS Script
		 *
		 * @return void		 
		 */

		public function printScript ()
		{
			if (!$this->addScript)
			{
				return false;
			}

			wp_enqueue_script('tms-accordion');
			wp_enqueue_style('tms-accordion');
		}

		/**
		 * Adds the shortcodes into Wordpress 'add_shortcode' method
		 *
		 * @return void		 
		 */

		public function addShortcodes ()
		{
			add_shortcode('accordion', array(&$this, 'accordionShortcode'));
			add_shortcode('accordion-panel', array(&$this, 'accordionPanelShortcode'));
		}

		/**
		 * Accordion callback | Renders shortcode for an accordion
		 *
		 * @param array $atts Attributes passed to the shortcode
		 * @param string $content Content passed into the shortcode
		 * @return void		 
		 */

		public function accordionShortcode ($atts, $content = '')
		{	
			$html            = '';
			$this->panels    = array();
			$this->addScript = true;

			$attributes  = shortcode_atts(array(

				'initial'     => 1,
				'speed'       => 375,
				'keepopen'    => 'true',
				'collapsible' => 'true'

			), $atts);

			$this->activePanel = $attributes['initial'];

			$html .= '<div class="tms-accordion" 
						   data-tms-accordion 
						   data-initial="'.$attributes['initial'].'" 
						   data-speed="'.$attributes['speed'].'"
						   data-keep-open="'.$attributes['keepopen'].'"
						   data-collapsible="'.$attributes['collapsible'].'"
					   >';

				$html .= do_shortcode($content);

			$html .= '</div>';

			return $html;
		}


		/**
		 * Accordion callback | Renders shortcode for an accordion
		 *
		 * @param array $atts Attributes passed to the shortcode
		 * @param string $content Content passed into the shortcode
		 * @return void		 
		 */

		public function accordionPanelShortcode ($atts, $content = '')
		{	
			$html = '';

			$this->panelsCounter++;

			$attributes = shortcode_atts(array(
				'title' => ''
			), $atts);

			$html.= '<h3 '.(($this->panelsCounter == $this->activePanel) ? 'class="active"' : '').'>'.$attributes['title'].'</h3>';
			$html.= '<section '.(($this->panelsCounter == $this->activePanel) ? 'class="active"' : '').'>'.do_shortcode($content).'</section>';

			return $html;
		}

		/**
		 * Removes <br /> & <p> tags from inside shortcode so formatting can be used
		 *
		 * @param array $content Content of the post
		 * @return String $html content without the troublesome tags		 
		 */

		public function removeChars ($content)
		{
			$block = join("|",array("accordion", "accordion-panel"));
			$rep   = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/","[$2$3]",$content);
			$rep   = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/","[/$2]",$rep);

			return $rep;
		}
	}

?>