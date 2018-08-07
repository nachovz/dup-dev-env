<?php
// ------------------------------------------------------------------------
// Create metaboxes in pages
// ------------------------------------------------------------------------
// Adds meta boxes to the main column on the Page edit screens.
	function themetek_add_meta_box() {
		$screens = array( 'page' );
		foreach ( $screens as $screen ) {
			// Page title meta box
			add_meta_box(
				'themetek_pagetitle',
				esc_html__( 'Page Title & Subtitle:', 'keysoft' ),
				'themetek_meta_box_pagetitle',
				$screen
			);
			// Page settings meta box
			add_meta_box(
				'themetek_pagesettings',
				esc_html__( 'Page Settings:', 'keysoft' ),
				'themetek_meta_box_pagesettings',
				$screen
			);
			
		}
	}
	add_action( 'add_meta_boxes', 'themetek_add_meta_box' );
// Print page title meta box content.
	function themetek_meta_box_pagetitle($post) {
		// Add an nonce field so we can check for it later
		wp_nonce_field( 'themetek_meta_box_pagetitle', 'themetek_meta_box_pagetitle_nonce' );
		// Retrieve an existing value from the database and use the value for the form.
		$themetek_page_showhide_title = get_post_meta( $post->ID, '_themetek_page_showhide_title', true );
		$themetek_page_subtitle = get_post_meta( $post->ID, '_themetek_page_subtitle', true );

		
		// Show/hide title on pages
		echo '<div class="tek_meta_block meta_block_top">';
			echo '<label for="page_showhide_title" style="width: 170px;display: inline-block;font-weight: bold;">';
				esc_html_e( 'Hide Page Title:', 'keysoft' );
			echo '</label>';
			$page_showhide_title_checked = '';
			if ($themetek_page_showhide_title == "yes") {
				$page_showhide_title_checked = 'checked="checked"';
			}
			echo '<input type="checkbox" id="page_showhide_title" name="page_showhide_title" value="yes" ' . esc_attr($page_showhide_title_checked) . '  />';
		echo '</div>';
		// Page subtitle text
		echo '<div class="tek_meta_block">';
			echo '<label for="page_subtitle" style="width: 170px;display: inline-block;font-weight: bold;">';
				esc_html_e( 'Page Subtitle:', 'keysoft' );
			echo '</label>';
			echo '<input type="text" class="page_subtitle_box" id="page_subtitle" name="page_subtitle" value="' . esc_attr( $themetek_page_subtitle ) . '" />';
		echo '</div>';	
	}
// Print page settings meta box content.
	function themetek_meta_box_pagesettings($post) {
		// Add an nonce field so we can check for it later
		wp_nonce_field( 'themetek_meta_box_pagesettings', 'themetek_meta_box_pagesettings_nonce' );
		// Retrieve an existing value from the database and use the value for the form.
		$themetek_page_bgcolor = get_post_meta( $post->ID, '_themetek_page_bgcolor', true );
		$themetek_page_top_padding = get_post_meta( $post->ID, '_themetek_page_top_padding', true );
		$themetek_page_bottom_padding =	get_post_meta( $post->ID, '_themetek_page_bottom_padding', true );

		
		// Get page background color
		echo '<div class="tek_meta_block meta_block_top">';
			echo '<label for="page_bgcolor" style="width: 170px;display: inline-block;font-weight: bold;">';
				esc_html_e( 'Page Background Color:', 'keysoft' );
			echo '</label>';
			echo '<input class="themetek-meta-color" type="text" id="page_bgcolor" name="page_bgcolor" value="' . esc_attr( $themetek_page_bgcolor ) . '" />';
		echo '</div>';
		  	// Get page top padding
		echo '<div class="tek_meta_block">';
			echo '<label for="page_top_padding" style="width: 170px;display: inline-block;font-weight: bold;">';
				esc_html_e( 'Page Top Padding:', 'keysoft' );
			echo '</label>';
			echo '<input type="text" id="page_top_padding" name="page_top_padding" value="' . esc_attr( $themetek_page_top_padding ) . '" />';
		echo '</div>';	  
	  	// Get page bottom padding
		echo '<div class="tek_meta_block">';
			echo '<label for="page_bottom_padding" style="width: 170px;display: inline-block;font-weight: bold;">';
				esc_html_e( 'Page Bottom Padding:', 'keysoft' );
			echo '</label>';
			echo '<input type="text" id="page_bottom_padding" name="page_bottom_padding" value="' . esc_attr( $themetek_page_bottom_padding ) . '" />';
		echo '</div>';


	}

// When the post is saved, saves our custom data. (Regular pages)
	function themetek_save_meta_box_data( $post_id ) {
		// Check if our nonce is set.
		if ( ! isset( $_POST['themetek_meta_box_pagesettings_nonce'] ) ) {
			return $post_id;
		}
		if ( ! isset( $_POST['themetek_meta_box_pagetitle_nonce'] ) ) {
			return $post_id;
		}
		
		$nonce_pagesettings = $_POST['themetek_meta_box_pagesettings_nonce'];
		$nonce_pagetitle = $_POST['themetek_meta_box_pagetitle_nonce'];
		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce_pagesettings, 'themetek_meta_box_pagesettings' ) ) {
			return $post_id;
		}
		if ( ! wp_verify_nonce( $nonce_pagetitle, 'themetek_meta_box_pagetitle' ) ) {
			return $post_id;
		}
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}
		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) )
			return $post_id;
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) )
			return $post_id;
		}
		/* OK, it's safe for us to save the data now. */
		// Sanitize user input and update the meta field in the database.
		if( isset( $_POST[ 'page_bgcolor' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_bgcolor', sanitize_text_field( $_POST[ 'page_bgcolor' ] ) );
    	}
    	if( isset( $_POST[ 'page_top_padding' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_top_padding', sanitize_text_field( $_POST[ 'page_top_padding' ] ) );
    	}
    	if( isset( $_POST[ 'page_bottom_padding' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_bottom_padding', sanitize_text_field( $_POST[ 'page_bottom_padding' ] ) );
    	}
		if( isset( $_POST[ 'page_showhide_title' ] ) ) {
		    update_post_meta( $post_id, '_themetek_page_showhide_title', 'yes' );
		} else {
		    update_post_meta( $post_id, '_themetek_page_showhide_title', '' );
		}
		if( isset( $_POST[ 'page_title_color' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_title_color', sanitize_text_field( $_POST[ 'page_title_color' ] ) );
    	}
    	if( isset( $_POST[ 'page_subtitle' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_subtitle', sanitize_text_field( $_POST[ 'page_subtitle' ] ) );
    	}
    	if( isset( $_POST[ 'page_subtitle_color' ] ) ) {
        	update_post_meta( $post_id, '_themetek_page_subtitle_color', sanitize_text_field( $_POST[ 'page_subtitle_color' ] ) );
    	}
    	if( isset( $_POST[ 'page_parallax_overlay' ] ) ) {
		    update_post_meta( $post_id, '_themetek_page_parallax_overlay', 'yes' );
		} else {
		    update_post_meta( $post_id, '_themetek_page_parallax_overlay', '' );
		}
	}
	add_action( 'save_post', 'themetek_save_meta_box_data' );
// When the post is saved, saves our custom data. (Portfolio item pages)
?>