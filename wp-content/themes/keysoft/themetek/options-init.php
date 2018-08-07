<?php
/**
ReduxFramework Sample Config File
For full documentation, please visit: https://docs.reduxframework.com
* */
if (!class_exists('keysoft_Redux_Framework_config')) {
    class keysoft_Redux_Framework_config
    {
        public $args = array();
        public $sections = array();
        public $theme;
        public $ReduxFramework;
        public function __construct()
        {
            if (!class_exists('ReduxFramework')) {
                return;
            }
            // This is needed. Bah WordPress bugs.  ;)
            if (true == Redux_Helpers::isTheme(__FILE__)) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array(
                    $this,
                    'initSettings'
                ), 10);
            }
        }
        public function initSettings()
        {
            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();
            // Set the default arguments
            $this->setArguments();
            // Set a few help tabs so you can see how it's done
            $this->setSections();
            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }
            // If Redux is running as a plugin, this will remove the demo notice and links
            add_action('redux/loaded', array(
                $this,
                'remove_demo'
            ));
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            add_filter('redux/options/' . $this->args['opt_name'] . '/compiler', array(
                $this,
                'compiler_action'
            ), 10, 2);
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));
            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }
        /**
        
        This is a test function that will let you see when the compiler hook occurs.
        It only runs if a field   set with compiler=>true is changed.
        
        * */
        function compiler_action($options, $css)
        {
        // echo '<h1>The compiler hook has run!</h1>';
        // print_r($options); //Option values
        // print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
          
            $filename = dirname(__FILE__).'/dynamic-keysoft.css';
            global $wp_filesystem;
            if (empty($wp_filesystem)) {
                require_once(ABSPATH . '/wp-admin/includes/file.php');
                WP_Filesystem();
            }
            if ($wp_filesystem) {
                $wp_filesystem->put_contents($filename, $css, FS_CHMOD_FILE // predefined mode settings for WP files
                    );
            }
        }
        /**
        
        Custom function for filtering the sections array. Good for child themes to override or add to the sections.
        Simply include this function in the child themes functions.php file.
        
        NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
        so you must use get_template_directory_uri() if you want to use any of the built in icons
        
        * */
        function dynamic_section($sections)
        {
            //$sections = array();
            $sections[] = array(
                'title' => esc_html__('Section via hook', 'keysoft'),
                'desc' => esc_html__('
    <p class="description">
        This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.
    </p>
    ', 'keysoft'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );
            return $sections;
        }
        /**
        
        Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
        
        * */
        function change_arguments($args)
        {
            //$args['dev_mode'] = true;
            return $args;
        }
        /**
        
        Filter hook for filtering the default value of any given field. Very useful in development mode.
        
        * */
        function change_defaults($defaults)
        {
            $defaults['str_replace'] = 'Testing filter hook!';
            return $defaults;
        }
        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo()
        {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2);
                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(
                    ReduxFrameworkPlugin::instance(),
                    'admin_notices'
                ));
            }
        }
        public function setSections()
        {
            /**
            Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
            * */
            // Background Patterns Reader
            $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns      = array();
            if (is_dir($sample_patterns_path)):
                if ($sample_patterns_dir = opendir($sample_patterns_path)):
                    $sample_patterns = array();
                    while (($sample_patterns_file = readdir($sample_patterns_dir)) !== false) {
                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name              = explode('.', $sample_patterns_file);
                            $name              = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[] = array(
                                'alt' => $name,
                                'img' => $sample_patterns_url . $sample_patterns_file
                            );
                        }
                    }
                endif;
            endif;
            ob_start();
            $ct              = wp_get_theme();
            $this->theme     = $ct;
            $item_name       = $this->theme->get('Name');
            $tags            = $this->theme->Tags;
            $screenshot      = $this->theme->get_screenshot();
            $class           = $screenshot ? 'has-screenshot' : '';
            $customize_title = sprintf(esc_html__('Customize &#8220;%s&#8221;', 'keysoft'), $this->theme->display('Name'));
?>
    <div id="current-theme" class="<?php
            echo esc_attr($class);
?>
        ">
        <?php
            if ($screenshot):
?>
        <?php
                if (current_user_can('edit_theme_options')):
?>
        <a href="<?php
                    echo esc_url(wp_customize_url());
?>
            " class="load-customize hide-if-no-customize" title="
            <?php
                    echo esc_attr($customize_title);
?>
            ">
            <img src="<?php
                    echo esc_url($screenshot);
?>
            " alt="
            <?php
                    esc_attr_e('Current theme preview','keysoft');
?>" /></a>
        <?php
                endif;
?>
        <img class="hide-if-customize" src="<?php
                echo esc_url($screenshot);
?>
        " alt="
        <?php
                esc_attr_e('Current theme preview','keysoft');
?>
        " />
        <?php
            endif;
?>

        <h4>
            <?php
            echo esc_attr($this->theme->display('Name'));
?></h4>

        <div>
            <ul class="theme-info">
                <li>
                    <?php
            printf(esc_html__('By %s', 'keysoft'), $this->theme->display('Author'));
?></li>
                <li>
                    <?php
            printf(esc_html__('Version %s', 'keysoft'), $this->theme->display('Version'));
?></li>
                <li>
                    <?php
            echo '<strong>' . esc_html__('Tags', 'keysoft') . ':</strong>
                ';
?>
                <?php
            printf($this->theme->display('Tags'));
?></li>
        </ul>
        <p class="theme-description">
            <?php
            echo esc_attr($this->theme->display('Description'));
?></p>

    </div>
</div>

<?php
            $item_info = ob_get_contents();
            ob_end_clean();
            $sampleHTML = '';
            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'icon' => 'el-icon-globe',
                'title' => esc_html__('Global Options', 'keysoft'),
                'compiler' => 'true',
                'fields' => array(
                    array(
                        'id' => 'tek-main-color',
                        'type' => 'color',
                        'title' => esc_html__('Main theme color', 'keysoft'),
                        'default' => '#1080f2',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-secondary-color',
                        'type' => 'color',
                        'title' => esc_html__('Secondary theme color', 'keysoft'),
                        'default' => '#273140',
                        'validate' => 'color'
                    ),
                    array(
                        'id' => 'tek-logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Logo', 'keysoft'),
                        'subtitle' => esc_html__('Upload logo image', 'keysoft'),
                        'default' => array(
                            'url' => 'http://keysoft-wp.keydesign-themes.com/wp-content/uploads/2015/11/logo.png'
                        )
                    ),                 
                    array(
                        'id' => 'tek-favicon',
                        'type' => 'media',
                        'preview' => false,
                        'url' => true,
                        'title' => esc_html__('Favicon', 'keysoft'),
                        'subtitle' => esc_html__('Upload favicon image', 'keysoft'),
                        'default' => array(
                            'url' => get_template_directory_uri() . '/images/favicon.png'
                        )
                    ),  
                    array(
                        'id' => 'tek-preloader',
                        'type' => 'switch',
                        'title' => esc_html__('Turn preloader on/off', 'keysoft'),
                        'subtitle' => esc_html__('Turn preloader on/off', 'keysoft'),
                        'default' => true
                    ), 
                    array(
                        'id' => 'tek-google-api',
                        'type' => 'text',
                        'title' => esc_html__('Google Map API Key', 'keysoft'),
                        'default' => '',
                        'subtitle' => esc_html__('Generate, copy and paste here Google Maps API Key', 'keysoft'),            
                    ),                   
                    array(
                        'id' => 'tek-css',
                        'type' => 'ace_editor',
                        'title' => esc_html__('Custom CSS', 'keysoft'),
                        'subtitle' => esc_html__('Paste your CSS code here.', 'keysoft'),
                        'mode' => 'css',
                        'theme' => 'chrome'
                    )
                )
            );


            $this->sections[] = array(
                'icon' => 'el-icon-screen',
                'title' => esc_html__('Header', 'keysoft'),
                'compiler' => 'true',
                'fields' => array(  
                    array(
                        'id' => 'tek-header-title',
                        'type' => 'text',
                        'title' => esc_html__('Header Title', 'keysoft'),
                        'default' => 'Keysoft, blissful innovation'
                        //                    
                    ),
                    array(
                        'id' => 'tek-header-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Header Subtitle', 'keysoft'),
                        'default' => 'Spend less time worrying about front-end and more focusing on your product'
                        //                    
                    ),
                    array(
                        'id' => 'tek-header-button1text',
                        'type' => 'text',
                        'title' => esc_html__('Primary Button Text', 'keysoft'),
                        'default' => 'Buy Now'
                        //                    
                    ),
                    array(
                        'id' => 'tek-header-button1url',
                        'type' => 'text',
                        'title' => esc_html__('Primary Button URL', 'keysoft'),
                        'default' => '#'
                        //                    
                    ),
                    array(
                        'id' => 'tek-header-button2text',
                        'type' => 'text',
                        'title' => esc_html__('Secondary Button Text', 'keysoft'),
                        'default' => 'Learn More'
                        //                    
                    ),
                    array(
                        'id' => 'tek-header-button2url',
                        'type' => 'text',
                        'title' => esc_html__('Secondary Button URL', 'keysoft'),
                        'default' => '#'
                        //                    
                    ),                    
                    array(
                        'id' => 'tek-header-color',
                        'type' => 'color',
                        'title' => esc_html__('Header Text Color', 'keysoft'),
                        'default' => '#fff',
                        'validate' => 'color'
                    ),
                    array(
                        'id'       => 'tek-header-type',
                        'type'     => 'select',
                        'title'    => esc_html__('Header Type', 'keysoft'), 
                        'options'  => array(
                            'dashboard' => 'Dashboard Version ( Demo 1)',
                            'mobile-app' => 'Mobile App Version ( Demo 2)',
                            'subscribe-form' => 'Subscrive Form Version ( Demo 3)'
                        ),
                        'default'  => 'dashboard',
                    ),
                    array(
                        'id' => 'tek-particles',
                        'type' => 'switch',
                        'title' => esc_html__('Header Particles Background', 'keysoft'),
                        'subtitle' => esc_html__('Turn on/off Header Particles', 'keysoft'),
                        'default' => true
                    ),                
                    array(
                        'id' => 'tek-header',
                        'type' => 'media',
                        'url' => true,
                        'title' => esc_html__('Header Image', 'keysoft'),
                        'subtitle' => esc_html__('Upload header image', 'keysoft'),
                        'default' => array(
                            'url' => 'http://keysoft-wp.keydesign-themes.com/wp-content/uploads/2016/01/header.png'
                        )
                    ),
                    array(
                        'id' => 'tek-bgvideo',
                        'type' => 'media',
                        'mode' => false,
                        'url' => true,
                        'title' => esc_html__('Background Video', 'keysoft'),
                        'subtitle' => esc_html__('Upload header background video', 'keysoft'),
                        'default' => array(
                            'url' => ''
                        )
                    ),
                    array(
                        'id' => 'tek-bgimage',
                        'type' => 'media',
                        'mode' => false,
                        'url' => true,
                        'title' => esc_html__('Background Image', 'keysoft'),
                        'subtitle' => esc_html__('Upload header background image', 'keysoft'),
                        'default' => array(
                            'url' => ''
                        )
                    ),
                    array(
                        'id' => 'tek-header-subscribe',
                        'type' => 'text',
                        'title' => esc_html__('Subscribe Contact Form ID', 'keysoft'),
                        'default' => '319'
                        //                    
                    ),
                )
            );
            
            
            $this->sections[] = array(
                'icon' => 'el-icon-fontsize',
                'title' => esc_html__('Typography', 'keysoft'),
                'compiler' => true,
                'fields' => array(
                    array(
                        'id' => 'tek-default-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Body font settings', 'keysoft'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => true,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => true,
                        'text-align' => true,
                        'preview' => true, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'compiler' => array(
                            'body, .box'
                        ), // An array of CSS selectors to apply this font style to dynamically
                        // 'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'default' => array(
                            'color' => '#666',
                            'font-weight' => '400',
                            'font-family' => 'PT Sans',
                            'google' => true,
                            'font-size' => '16px',
                            'text-align' => 'left',
                            'line-height' => '25px'
                        ),
                        'preview' => array(
                            'text' => 'keysoft Sample Text'
                        )
                    ),
                    array(
                        'id' => 'tek-heading-typo',
                        'type' => 'typography',
                        'title' => esc_html__('Headings font settings', 'keysoft'),
                        //'compiler'      => true,  // Use if you want to hook in your own CSS compiler
                        'google' => true, // Disable google fonts. Won't work if you haven't defined your google api key
                        // 'font-backup'   => true,    // Select a backup non-google font in addition to a google font
                        'font-style' => true, // Includes font-style and weight. Can use font-style or font-weight to declare
                        //'subsets'       => false, // Only appears if google is true and subsets not set to false
                        'font-size' => true,
                        'line-height' => true,
                        //'word-spacing'  => true,  // Defaults to false
                        //'letter-spacing'=> true,  // Defaults to false
                        'color' => true,
                        'text-align' => true,
                        'preview' => true, // Disable the previewer
                        'all_styles' => true, // Enable all Google Font style/weight variations to be added to the page
                        'compiler' => array(
                            '.container h1,.container h2,.container h3, .pricing .col-lg-3, .chart'
                        ), // An array of CSS selectors to apply this font style to dynamically
                        // 'compiler'      => array('h2.site-description-compiler'), // An array of CSS selectors to apply this font style to dynamically
                        'units' => 'px', // Defaults to px
                        'default' => array(
                            'color' => '#333',
                            'font-weight' => '300',
                            'font-family' => 'Work Sans',
                            'google' => true,
                            'font-size' => '50px',
                            'text-align' => 'center',
                            'line-height' => '40px'
                        ),
                        'preview' => array(
                            'text' => 'keysoft Sample Text'
                        )
                    )                    
                )
            );
           
            $this->sections[] = array(
                'icon' => 'el-icon-pencil-alt',
                'title' => esc_html__('Blog', 'keysoft'),
                'fields' => array(
                    array(
                        'id' => 'tek-blog-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Blog Subtitle', 'keysoft'),
                        'default' => 'Keysoft, blissful innovation, professional and easy-to-use software'
                        //                    
                    ),
                    array(
                        'id' => 'tek-blog-sidebar',
                        'type' => 'switch',
                        'title' => esc_html__('Display sidebar', 'keysoft'),
                        'subtitle' => esc_html__('Turn on/off blog sidebar', 'keysoft'),
                        'default' => true
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-error-alt',
                'title' => esc_html__('404 Page', 'keysoft'),
                'fields' => array(
                    array(
                        'id' => 'tek-404-title',
                        'type' => 'text',
                        'title' => esc_html__('Title', 'keysoft'),
                        'default' => 'Error 404'
                        //                    
                    ),
                    array(
                        'id' => 'tek-404-subtitle',
                        'type' => 'text',
                        'title' => esc_html__('Subtitle', 'keysoft'),
                        'default' => 'This page could not be found!'
                        //                    
                    ),
                    array(
                        'id' => 'tek-404-back',
                        'type' => 'text',
                        'title' => esc_html__('Back to homepage text', 'keysoft'),
                        'default' => 'Back to homepage'
                        //                    
                    )
                )
            );
            $this->sections[] = array(
                'icon' => 'el-icon-thumbs-up',
                'title' => esc_html__('Footer', 'keysoft'),
                'fields' => array(
                    
                    array(
                        'id' => 'tek-footer-text',
                        'type' => 'text',
                        'title' => esc_html__('Copyright Text', 'keysoft'),
                        'subtitle' => esc_html__('Enter footer bottom copyright text', 'keysoft'),
                        'default' => 'Copyright 2016 KeySoft by KeyDesign. All rights reserved'
                    ),
                    array(
                        'id' => 'tek-social-icons',
                        'type' => 'checkbox',
                        'title' => esc_html__('Social Icons', 'keysoft'),
                        'subtitle' => esc_html__('Select visible social icons', 'keysoft'),
                        //Must provide key => value pairs for multi checkbox options
                        'options' => array(
                            '1' => 'Facebook',
                            '2' => 'Twitter',
                            '3' => 'Google+',
                            '4' => 'Pinterest',
                            '5' => 'Youtube',
                            '6' => 'Linkedin'
                        ),
                        //See how std has changed? you also don't need to specify opts that are 0.
                        'default' => array(
                            '1' => '1',
                            '2' => '1',
                            '3' => '1',
                            '4' => '1',
                            '5' => '1',
                            '6' => '1'
                        )
                    ),
                    array(
                        'id' => 'tek-facebook-url',
                        'type' => 'text',
                        'title' => esc_html__('Facebook Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Facebook url', 'keysoft'),
                        'validate' => 'url',
                        'default' => 'http://facebook.com'
                    ),
                   
                    array(
                        'id' => 'tek-twitter-url',
                        'type' => 'text',
                        'title' => esc_html__('Twitter Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Twitter url', 'keysoft'),
                        'validate' => 'url',
                        'default' => 'http://twitter.com'
                    ),
                    
                    array(
                        'id' => 'tek-google-url',
                        'type' => 'text',
                        'title' => esc_html__('Google+ Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Google+ url', 'keysoft'),
                        'default' => 'http://plus.google.com'
                    ),
                    array(
                        'id' => 'tek-pinterest-url',
                        'type' => 'text',
                        'title' => esc_html__('Pinterest Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Pinterest url', 'keysoft'),
                        'validate' => 'url',
                        'default' => 'http://pinterest.com'
                    ),                   
                    array(
                        'id' => 'tek-youtube-url',
                        'type' => 'text',
                        'title' => esc_html__('Youtube Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Youtube url', 'keysoft'),
                        'validate' => 'url',
                        'default' => 'http://youtube.com'
                    ),
                    array(
                        'id' => 'tek-linkedin-url',
                        'type' => 'text',
                        'title' => esc_html__('Linkedin Link', 'keysoft'),
                        'subtitle' => esc_html__('Enter Linkedin url', 'keysoft'),
                        'validate' => 'url',
                        'default' => 'http://linkedin.com'
                    ),                    
                )
            );
            $this->sections[] = array(
                'title' => esc_html__('Import/Export ', 'keysoft'),
                'desc' => esc_html__('', 'keysoft'),
                'icon' => 'el-icon-magic',
                'fields' => array(
                    array(
                        'id' => 'opt-import-export',
                        'type' => 'import_export',
                        'title' => 'Import and Export keysoft Options',
                        'subtitle' => '',
                        'full_width' => false
                    )
                )
            );
        }
        /**
        
        All the possible arguments for Redux.
        For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
        
        * */
        public function setArguments()
        {
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args                    = array(
                'opt_name' => 'redux_ThemeTek',
                'page_slug' => 'options_themetek',
                'page_title' => 'ThemeTek Options',
                'dev_mode' => '0',
                'update_notice' => '1',
                'admin_bar' => '1',
                'menu_type' => 'submenu',
                'page_parent' => 'themes.php',
                'menu_title' => 'Theme Options',
                'allow_sub_menu' => '1',
                'page_parent_post_type' => 'your_post_type',
                'customizer' => false,
                'class' => '',
                'hints' => array(
                    'icon' => 'el-icon-question-sign',
                    'icon_position' => 'right',
                    'icon_size' => 'normal',
                    'tip_style' => array(
                        'color' => 'light'
                    ),
                    'tip_position' => array(
                        'my' => 'top left',
                        'at' => 'bottom right'
                    ),
                    'tip_effect' => array(
                        'show' => array(
                            'duration' => '500',
                            'event' => 'mouseover'
                        ),
                        'hide' => array(
                            'duration' => '500',
                            'event' => 'mouseleave unfocus'
                        )
                    )
                ),
                'output' => '1',
                'output_tag' => '1',
                'compiler' => '1',
                'page_icon' => 'icon-themes',
                'page_permissions' => 'manage_options',
                'save_defaults' => '1',
                'show_import_export' => '1',
                'transient_time' => '3600',
                'network_sites' => '1'
            );
            $theme                         = wp_get_theme(); // For use with some settings. Not necessary.
            $this->args["display_name"]    = $theme->get("Name");
            $this->args["display_version"] = $theme->get("Version");
         
        }
    }
    global $reduxConfig;
    $reduxConfig = new keysoft_Redux_Framework_config();
}
/**
Custom function for the callback referenced above
*/
if (!function_exists('keysoft_my_custom_field')):
    function keysoft_my_custom_field($field, $value)
    {
        print_r($field);
        echo '
<br/>
';
        print_r($value);
    }
endif;
/**
Custom function for the callback validation referenced above
* */
if (!function_exists('keysoft_validate_callback_function')):
    function keysoft_validate_callback_function($field, $value, $existing_value)
    {
        $error           = false;
        $value           = 'just testing';
        /*
        do your validation
        
        if(something) {
        $value = $value;
        } elseif(something else) {
        $error = true;
        $value = $existing_value;
        $field['msg'] = 'your custom error message';
        }
        */
        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;