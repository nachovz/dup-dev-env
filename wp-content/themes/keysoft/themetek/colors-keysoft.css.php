<?php
$parse_uri = explode('wp-content', $_SERVER['SCRIPT_FILENAME']);
require_once($parse_uri[0] . 'wp-load.php');
header("Content-type: text/css; charset: UTF-8");
?>

.fa,
.contact .wpcf7-response-output,
.video-bg .secondary-button:hover,
.navbar-default .navbar-nav>.active>a,
#headerbg li a.active,
#headerbg li a.active:hover,
.footer-nav a:hover ,
.wpb_wrapper .menu a:hover ,
.text-danger,
.navigation.pagination .next:hover,
.navigation.pagination .prev:hover,
.blog_widget ul li a:before,
.pricing .fa,
.searchform #searchsubmit:hover,
code,
#single-page .single-page-content ul li:before,
.blog_widget ul li a:hover,
.subscribe-form header .wpcf7-submit,
#posts-content .page-content ul li:before,
#recentcomments a,
.pricing .col-lg-3,
.chart-content .nc-icon-outline,
.chart,
.contact .wpcf7-not-valid-tip,
.features-tabs .tab:hover a,
.features-tabs .tab a.active,
.secondary-button-inverse,
.primary-button.button-inverse:hover,
.primary-button,
a,
.nc-icon-outline
{
	color: <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}

#commentform #submit,
.contact .wpcf7-submit,
.team-content,
.pricing .secondary-button.secondary-button-inverse:hover,
.pricing.active,
#preloader,
.tags a:hover, .tagcloud a:hover,
.secondary-button.secondary-button-inverse:hover,
.secondary-button,
.primary-button.button-inverse,
#posts-content .post input[type="submit"],
.parallax,
.btn-xl,
.blog-header .header-overlay,
.pricing-title,
.separator,
#header 
{
background: <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}

::selection {background: <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;}
::-moz-selection {background: <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;}

.pricing.active,
.primary-button.button-inverse:hover,
.primary-button.button-inverse {
    border: 2px solid <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}

#commentform input:focus,
#commentform textarea:focus,
.navigation.pagination .next:hover, .navigation.pagination .prev:hover,
.contact .wpcf7-response-output,
.video-bg .secondary-button,
.image-bg .secondary-button,
.contact .wpcf7-form-control-wrap textarea.wpcf7-form-control:focus,
.contact .wpcf7-form-control-wrap input.wpcf7-form-control:focus,
.team-member-down:hover .triangle,
.team-member:hover .triangle,
.searchform #s:focus,
.secondary-button-inverse  {
    border-color: <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}


.team-content .triangle {
     border-bottom: 10px solid  <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}

.team-member-down .triangle  {
     border-top: 10px solid  <?php echo esc_attr($redux_ThemeTek['tek-main-color']); ?>;
}

#wp-calendar caption,
.post a:hover,
.navigation.pagination .next,
.navigation.pagination .prev,
.testimonials .tt-content h4, 
.widget-title,
.reply-title,
.subscribe input[type="submit"], 
.testimonials .tt-content .content {
	color: <?php echo esc_attr($redux_ThemeTek['tek-heading-typo']['color']); ?>;
}

#menu-main-menu .menu-item-has-children .dropdown-menu,
#commentform #submit:hover,
.navbar-default,
.subscribe-form header .wpcf7-submit:hover,
#headerbackground,
.contact .wpcf7-submit:hover,
footer,
#posts-content .post input[type="submit"]:hover,
.navbar-default.navbar-shrink,
.btn-xl:hover,
.btn-xl:focus,
.btn-xl:active,
.btn-xl.active {
background: <?php echo esc_attr($redux_ThemeTek['tek-secondary-color']); ?>;
}

.subscribe-form header .wpcf7-response-output,
.subscribe .wpcf7-mail-sent-ok,
.subscribe .wpcf7-not-valid-tip,
.secondary-button:hover {
color: <?php echo esc_attr($redux_ThemeTek['tek-secondary-color']); ?>;
}

.blog-header  .section-heading {
color:<?php echo esc_attr($redux_ThemeTek['tek-header-color']); ?>
}