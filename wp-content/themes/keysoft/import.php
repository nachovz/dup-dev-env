<form name="input" action="themes.php?page=import-demo&import" method="post">
URL: <input type="text" name="url">
<input type="submit" value="Submit">
</form>

<?php
set_time_limit(-1);
if(isset($_POST['url'])) {
	

	class WP_Import_Custom extends WP_Import {
		var $file = '';
		function import_end() {
			// unlink($this->file);
			wp_cache_flush();
			foreach ( get_taxonomies() as $tax ) {
				delete_option( "{$tax}_children" );
				_get_term_hierarchy( $tax );
			}

			wp_defer_term_counting( false );
			wp_defer_comment_counting( false );
		}
	}

	$keysoft_demo_content = $_POST['url'].'/demo_content.xml';

	$keysoft_check_files = keysoft_check_import_files($keysoft_demo_content);
	if( isset($keysoft_check_files['erros']) ){
		echo 'The following files were not found:';
		foreach ($keysoft_check_files as $file) {
			echo esc_attr($file);
		}
	} else {
		$keysoft_upload_dir = wp_upload_dir();
		if(!is_dir($keysoft_upload_dir['path'])){
			mkdir($keysoft_upload_dir['path'], 0755, true);
		}
		$imported_files = keysoft_import_theme_files($keysoft_upload_dir['path'], $keysoft_demo_content);

		//print_r($imported_files);
		$wp_importer = new WP_Import_Custom();
		$wp_importer->fetch_attachments = true;
		$_POST['user_map'][0] = 0;
		$_POST['imported_authors'][0] = 'admin';
		$wp_importer->import( $imported_files['demo'] );

		// Use a static front page
		$keysoft_home = get_page_by_title( 'Home' );
		update_option( 'page_on_front', $keysoft_home->ID );
		update_option( 'show_on_front', 'page' );

		// Set the blog page
		$keysoft_blog = get_page_by_title( 'Blog' );
		update_option( 'page_for_posts', $keysoft_blog->ID );		
		
	}
}
?>