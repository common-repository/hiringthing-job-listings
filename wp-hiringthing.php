<?php
/*
Plugin Name: Wp HiringThing
Plugin URI: http://www.hiringthing.com
Description: HiringThing is online software that helps companies post jobs online, manage applicants and hire great employees. If you don't yet have a HiringThing account, visit <a target="_blank" href="http://www.hiringthing.com">http://www.hiringthing.com</a> for a free trial.  Once this plugin is activated, you will see the HiringThing widget available to add to your layout.
Version: 1.0.1
Author: hiringthing.com
Author URI: http://www.hiringthing.com

HiringThing is online software that helps companies post jobs online, manage applicants and hire great employees. If you don't yet have a HiringThing account, visit <a target="_blank" href="http://www.hiringthing.com">http://www.hiringthing.com</a> for a free trial.  Once this plugin is activated, you will see the HiringThing widget available to add to your layout.
*/
add_action('widgets_init', create_function('', 'register_widget("WP_Hiringthing_Widget");'));
class WP_Hiringthing_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct('wp_hiringthing_widget', 'WP Hiringthing Widget', array('description' => 'HiringThing is online software that helps companies post jobs online, manage applicants and hire great employees.') // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract($args);
		$title = apply_filters('widget_title', $instance['title']);
		$site_url = $instance['site_url'];

		echo $before_widget;
		if (!empty($title)) { echo $before_title.$title.$after_title; }
		if($site_url != '') {
			echo '<!-- HiringThing Jobs Widget -->';
			echo '<script type="text/javascript">';
				echo 'var ht_settings = ( ht_settings || new Object() );';
				echo 'ht_settings.site_url = "'.$site_url.'";';
				echo 'ht_settings.src_code = "wordpress";';
			echo '</script>';
			echo '<script src="http://assets.hiringthing.com/javascripts/embed.js" type="text/javascript"></script>';
			echo '<div id="hiringthing-jobs"></div>';
			echo '<link rel="stylesheet" type="text/css" media="all" href="http://assets.hiringthing.com/stylesheets/embed.css" />';
			echo '<!-- end HiringThing Jobs Widget -->';
		} else {
			echo '<p>Please Enter your HiringThing Account URL in the Widgets Section.</p>';
		}
		echo $after_widget;
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update($new_instance, $old_instance) {
		$instance = array();
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['site_url'] = strip_tags($new_instance['site_url']);
		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form($instance) {
		$title = 'HiringThing Jobs';
		$site_url = '';
		if (isset($instance['title'])) {
			$title = $instance['title'];
		}		
		if (isset($instance['site_url'])) {
			$site_url = $instance['site_url'];
		}
		echo '<p style="text-align: justify;">';
			echo '<a href="http://www.hiringthing.com" target="_blank"><img src="'.WP_PLUGIN_URL.'/wp-hiringthing/images/logo.png" style="width: 100%;" /></a>';
			echo 'HiringThing is online software that helps companies post jobs online, manage applicants and hire great employees. If you don\'t yet have a HiringThing account, visit <a href="http://www.hiringthing.com" target="_blank">http://www.hiringthing.com</a> for a 30-day free trial.';
		echo '</p>';
		echo '<p>';
			echo '<label for="'.$this->get_field_id('title').'">Title:</label>';
			echo '<input class="widefat" id="'.$this->get_field_id('title').'" name="'.$this->get_field_name('title').'" type="text" value="'.esc_attr($title).'" />';
		echo '</p>';
		echo '<p>';
			echo '<label for="'.$this->get_field_id('site_url').'">HiringThing Account URL:</label><br />';
			echo '<input class="narrowfat" id="'.$this->get_field_id('site_url').'" name="'.$this->get_field_name('site_url').'" type="text" value="'.esc_attr($site_url).'" /><small>.hiringthing.com</small>';
		echo '</p>';
	}
}
?>
