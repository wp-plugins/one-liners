<?php
/*
Plugin Name: One Liners
Plugin URI: http://thebrent.net/projects/one-liners/
Description: Custom post type for short oneliners, including a widget and shortcode.
Version: 3.1.0
Author: Brent Maxwell
Author URI: http://thebrent.net/
Text Domain: thebrent_oneliners
License: GPL2
*/

class theBrent_Oneliners{
	
	public function __construct(){
		register_activation_hook( __FILE__, array( $this,'activate') );
		register_deactivation_hook( __FILE__, array( $this,'deactivate') );
		load_plugin_textdomain ( 'thebrent_oneliners', false, dirname( __FILE__ ) . '/languages');
		do_action('thebrent_oneliners_init');
		add_action('init', array($this, 'init'));
		add_action('widgets_init', array( $this, 'widgets_init' ));
		add_action('admin_init', array($this,'admin_init'));
		add_action('admin_menu', array($this,'admin_menu'));
		add_action('updated_option',array($this,'update_option'));
	}
	
	public function init(){
		$this->register_post_type();
		add_shortcode( 'random-oneliner', array( $this , 'get_random_oneliner' ) );
	}
	
	public function admin_init(){
		$this->register_settings();
	}
	
	public function widgets_init(){
		register_widget( 'theBrentOnelinersWidget' );
		add_filter('widget_text', 'do_shortcode');
	}
	
	public function register_settings(){
		register_setting( 'thebrent_oneliners_options', 'thebrent_oneliners_options' );

		add_settings_section(
			'thebrent_oneliners_options_section', 
			__( 'Settings', 'thebrent_oneliners' ), 
			array($this,'thebrent_oneliners_settings_section_callback'), 
			'thebrent_oneliners_options'
		);
	
		add_settings_field( 
			'thebrent_oneliners_options_slug', 
			__( 'Slug', 'thebrent_oneliners' ), 
			array($this,'thebrent_oneliners_slug_field_callback'), 
			'thebrent_oneliners_options', 
			'thebrent_oneliners_options_section' 
		);
		
	}
	
	function thebrent_oneliners_settings_section_callback(  ) { 
		echo __( 'Oneliners options', 'thebrent_oneliners' );
	}
	
	function thebrent_oneliners_slug_field_callback(  ) { 
		$options = get_option( 'thebrent_oneliners_options' );
		?><input type='text' name='thebrent_oneliners_options[slug]' value='<?php echo $options['slug']; ?>'><?php
	}
	
	public function settings_page(){
		include('settings.php');
	}
	
	public function activate(){
		$this->set_default_options();
		$this->register_post_type();
		flush_rewrite_rules();
	}
	
	public function update_option($option)
	{
		if($option =='thebrent_oneliners_options'){
			$this->register_post_type();
			flush_rewrite_rules();
		}
	}
	
	public function admin_menu(){
		add_submenu_page(
			'edit.php?post_type=thebrent_oneliners',
			__('Options','thebrent_oneliners'),
			__('Options','thebrent_oneliners'),
			'manage_options',
			'thebrent_oneliners_options',
			array($this,'settings_page')
		);
	}
	
	public function set_default_options(){
		if(! get_option('thebrent_oneliners_options')){
			$options = array(
				'slug' => 'oneliners'
			);
			add_option('thebrent_oneliners_options', $options);
		}
	}
	
	public function register_post_type(){
		$options = get_option('thebrent_oneliners_options');
		register_post_type( 'thebrent_oneliners',
			array(
				'labels' => array(
					'name'               => __( 'Oneliners', 'thebrent_oneliners' ),
					'singular_name'      => __( 'Oneliner', 'thebrent_oneliners' ),
					'add_new_item'       => __( 'Add New Oneliner', 'thebrent_oneliners' ),
					'edit_item'          => __( 'Edit Oneliner', 'thebrent_oneliners' ),
					'new_item'           => __( 'New Oneliner', 'thebrent_oneliners' ),
					'view_item'          => __( 'View Oneliner', 'thebrent_oneliners' ),
					'search_items'       => __( 'Search Oneliners', 'thebrent_oneliners' ),
					'not_found'          => __( 'No oneliners found', 'thebrent_oneliners' ),
					'not_found_in_trash' => __( 'No oneliners found in trash', 'thebrent_oneliners' ),
					'parent_item_colon'  => __( ':', 'thebrent_oneliners' ),
				),
				'description'            => __( 'Oneliners', 'thebrent_oneliners' ),
				'public'                 => true,
				'capability_type'        => 'post',
				'supports'               => array(
					'title'
				),
				'rewrite'                => array(
					'slug'               => $options['slug'],
				),
				'menu_icon'              => 'dashicons-format-quote'
			)
		);
	}

	// Main function to to query the posts and return a random item.
	public function get_random_oneliner($attr = null)
	{
		$args = array(
			'post_type' => 'thebrent_oneliners',
			'posts_per_page' => 1,
			'orderby' => 'rand',
		);

		if(isset($attr))
		{
			foreach($attr as $key=>$value)
			{
				if($key != 'post_type' && in_array($key, $args))
				{
					$args[$key] = $value;
				}
			}
		}

		$args = apply_filters('thebrent_oneliners_random_args',$args);
		$out = '';
		$loop = new WP_Query( $args );

		while( $loop->have_posts() )
		{	
			
			$loop->the_post();
			$out .= '<span class="oneliner">';
			if(isset($attr['display_as_link']) && $attr['display_as_link']){
				$out .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
			}
			else {
				$out .= get_the_title();
			}
			$out .= '</span>';
		}
		$out = apply_filters('thebrent_oneliners_random_oneliner',$out);

		return $out;
		
	}
	
	// Display the random quote; primarily to be used from theme files.
	public function show($attr = null)
	{
		$out = $this->get_random_oneliner($attr);
		$out = apply_filters('thebrent_oneliners_show',$out);
		echo $out;
	}
	
	public function deactivate(){
		flush_rewrite_rules();
	}
	
}

include('widget.php');
 
$wpOneLiners = new theBrent_Oneliners();