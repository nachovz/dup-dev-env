<?php
// Load the TGM init if it exists
if (file_exists(get_template_directory() . '/themetek/tgm/tgm-init.php')) {
    require_once(get_template_directory() . '/themetek/tgm/tgm-init.php');
}
// Load Redux extensions - MUST be loaded before your options are set
if (file_exists(get_template_directory() . '/themetek/themetek-extensions/extensions-init.php')) {
    require_once(get_template_directory() . '/themetek/themetek-extensions/extensions-init.php');
}
// Load the embedded Redux Framework
if (file_exists(get_template_directory() . '/themetek/themetek-framework/ReduxCore/framework.php')) {
    require_once(get_template_directory() . '/themetek/themetek-framework/ReduxCore/framework.php');
}
// Load the theme/plugin options
if (file_exists(get_template_directory() . '/themetek/options-init.php')) {
    require_once(get_template_directory() . '/themetek/options-init.php');
}
