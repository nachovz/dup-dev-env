<?php
// ------------------------------------------------------------------------
// Include the TGM_Plugin_Activation class
// ------------------------------------------------------------------------

include_once (get_template_directory() . '/plugins/class-tgm-plugin-activation.php');

// Register the required plugins for this theme.

if (!function_exists('themetek_register_plugins'))
	{
	function themetek_register_plugins()
		{
		$plugins = array( // Wordpress Importer
			array(
				'name' => 'Wordpress Importer',
				'slug' => 'wordpress-importer',
				'source' => get_stylesheet_directory() . '/plugins/wordpress-importer.zip',
				'required' => true,
				'version' => '',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			) ,
			array(
				'name' => 'Visual Composer',
				'slug' => 'js_composer',
				'source' => get_stylesheet_directory() . '/plugins/js-composer.zip',
				'required' => true,
				'version' => '',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			) ,
			array(
				'name' => 'KeyDesign VC Addon',
				'slug' => 'tt-vc-addon',
				'source' => get_stylesheet_directory() . '/plugins/keydesign-vc-addon.zip',
				'required' => true,
				'version' => '',
				'force_activation' => false,
				'force_deactivation' => true,
				'external_url' => '',
			) ,
			array(
				'name' => 'Contact Form 7',
				'slug' => 'contact-form-7',
				'required' => true,
			) ,
		);

		// Change this to your theme text domain, used for internationalising strings

		$keysoft_theme_text_domain = 'keysoft';
		$config = array(
			'domain' => $keysoft_theme_text_domain, // Text domain - likely want to be the same as your theme.
			'default_path' => '', // Default absolute path to pre-packaged plugins
			'parent_menu_slug' => 'themes.php', // Default parent menu slug
			'parent_url_slug' => 'themes.php', // Default parent URL slug
			'menu' => 'install-required-plugins', // Menu slug
			'has_notices' => true, // Show admin notices or not
			'is_automatic' => true, // Automatically activate plugins after installation or not
			'message' => '', // Message to output right before the plugins table
			'strings' => array(
				'page_title' => esc_html__('Install Required Plugins', 'keysoft') ,
				'menu_title' => esc_html__('Install Plugins', 'keysoft') ,
				'installing' => esc_html__('Installing Plugin: %s', 'keysoft') , // %1$s = plugin name
				'oops' => esc_html__('Something went wrong with the plugin API.', 'keysoft') ,
				'notice_can_install_required' => esc_html__('This theme requires the following plugin: %1$s.', 'keysoft') , // %1$s = plugin name(s)
				'notice_can_install_recommended' => esc_html__('This theme recommends the following plugin: %1$s.', 'keysoft') , // %1$s = plugin name(s)
				'notice_cannot_install' => esc_html__('Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'keysoft') , // %1$s = plugin name(s)
				'notice_can_activate_required' => esc_html__('The following required plugin is currently inactive: %1$s.', 'keysoft') , // %1$s = plugin name(s)
				'notice_can_activate_recommended' => esc_html__('The following recommended plugin is currently inactive: %1$s.', 'keysoft') , // %1$s = plugin name(s)
				'notice_cannot_activate' => esc_html__('Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'keysoft') , // %1$s = plugin name(s)
				'notice_ask_to_update' => esc_html__('The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'keysoft') , // %1$s = plugin name(s)
				'notice_cannot_update' => esc_html__('Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'keysoft') , // %1$s = plugin name(s)
				'install_link' => esc_html__('Begin installing plugin', 'keysoft') ,
				'activate_link' => esc_html__('Activate installed plugin', 'keysoft') ,
				'return' => esc_html__('Return to Required Plugins Installer', 'keysoft') ,
				'plugin_activated' => esc_html__('Plugin activated successfully.', 'keysoft') ,
				'complete' => esc_html__('All plugins installed and activated successfully. %s', 'keysoft') , // %1$s = dashboard link
				'nag_type' => 'updated'

				// Determines admin notice type - can only be 'updated' or 'error'

			)
		);
		tgmpa($plugins, $config);
		}
	}

add_action('tgmpa_register', 'themetek_register_plugins');
?>