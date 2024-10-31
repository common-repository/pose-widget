<?php
/*
Plugin Name: Pose
Plugin URI: http://www.pose.com
Description: Gives you a Pose widget you can add to your sidebar.
Version: 1.0.0
Author: Pose
Author URI: http://www.pose.com
License: GPL2
*/

/*  Copyright 2011  by Pose  (email : support@pose.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


add_action( 'widgets_init', create_function( '', 'return register_widget("PoseWidget");' ) );


class PoseWidget extends WP_Widget {
	/** constructor */
	function PoseWidget() {
		parent::WP_Widget( 'PoseWidget', $name = 'Pose Widget' );
	}

	/** @see WP_Widget::widget */
	function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( $title )
			echo $before_title . $title . $after_title; ?>
				<div id="pose-widget-container" style="width:250px;<?= ($instance['align'] == "center") ? "margin: 0 auto;" : "" ?>"></div>		
				<script type="text/javascript">
				var posew_username = '<?= $instance['username'] ?>';
				</script>
				<script type="text/javascript" async=true src="http://pose.com/widgets/myposes/grid.js"></script>
		<?php echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['username'] = strip_tags($new_instance['username']);
		$instance['align'] = strip_tags($new_instance['align']);
		return $instance;
	}

	/** @see WP_Widget::form */
	function form( $instance ) {
		if ( $instance ) {
			$title = esc_attr( $instance[ 'title' ] );
			$username = esc_attr( $instance[ 'username' ] );
			$align = esc_attr( $instance[ 'align' ] );
		}
		else {
			$title = __( 'New title', 'text_domain' );
			$username = __( 'user name', 'text_domain' );
			$align = __( 'left', 'text_domain' );
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('username'); ?>"><?php _e('Pose Username:'); ?></label> 
		<input class="widefat" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo $username; ?>" />
		</p>
		<p>
		<label for="<?php echo $this->get_field_id('align'); ?>"><?php _e('Alignment:'); ?></label> 
		<select class="widefat" id="<?php echo $this->get_field_id('align'); ?>" name="<?php echo $this->get_field_name('align'); ?>">
			<option value="left" <?php selected('left', $align); ?>>Left</option>
			<option value="center" <?php selected('center', $align); ?>>Center</option>
		</select>
		</p>
		<?php 
	}

} // class PoseWidget

?>