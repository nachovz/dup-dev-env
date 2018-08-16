<?php $redux_ThemeTek = get_option( 'redux_ThemeTek' ); ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
   <head>
      <meta charset="<?php bloginfo( 'charset' ); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
      <?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) {?>
      <link href=" <?php echo esc_url($redux_ThemeTek['tek-favicon']['url']); ?>" rel="icon">
      <?php } ?>
      <link rel="pingback" href="<?php  esc_url(bloginfo( 'pingback_url' )); ?>" />
      <style type="text/css"><?php if (isset($redux_ThemeTek['tek-css'] ))   {  echo esc_attr( $redux_ThemeTek['tek-css'] ); }  ?></style>
      <?php  wp_head(); ?>
      <link href="#" class="css-color" rel="stylesheet">
   </head>
   <body <?php body_class();?>>
      <?php if ( function_exists( 'gtm4wp_the_gtm_tag' ) ) { gtm4wp_the_gtm_tag(); } ?>
        <?php if ($redux_ThemeTek['tek-preloader']) { ?>
         <div id="preloader">
             <div class="spinner"></div>
         </div>
        <?php } ?>      
      <?php  if ($redux_ThemeTek['tek-bgvideo']['url']): ?> 
      <input type="hidden" id="bg-video" value="<?php  echo esc_url($redux_ThemeTek['tek-bgvideo']['url']);   ?>">
      <?php  endif; ?>
      <nav class="navbar navbar-default navbar-fixed-top" role="navigation" >
         <div class="container">
            <div id="logo">
               <a class="logo" href="<?php  echo esc_url(site_url()); ?>">
               <?php  if ($redux_ThemeTek['tek-logo']['url']) { ?>
               <img class="fixed-logo" src="<?php  echo esc_url($redux_ThemeTek['tek-logo']['url']);   ?>" alt="" />
               <?php  } else  bloginfo('name')  ?></a>
            </div>
           <div class="navbar-header page-scroll">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-menu">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    </button>
            </div>
            <div id="main-menu" class="collapse navbar-collapse  navbar-right">
               <?php 
                  wp_nav_menu( array( 'menu' => 'keysoft-header-menu', 'depth' => 2, 'container' => false, 'menu_class' => 'nav navbar-nav', 'fallback_cb' => 'wp_bootstrap_navwalker::fallback', 'walker' => new wp_bootstrap_navwalker()) );
               ?>
            </div>
         </div>
      </nav>
      <div id="wrapper">
      <?php  if( is_page('Home')) { ?>
      <header id="header" <?php if ($redux_ThemeTek['tek-bgvideo']['url']) { echo "class='video-bg'";} if ($redux_ThemeTek['tek-bgimage']['url']) { echo "class='image-bg'"; } ?> >
         <div class="container">
            <div class="intro-text">
               <h1 class="intro-lead-in" style="color:<?php echo esc_attr($redux_ThemeTek['tek-header-color']); ?>"><?php echo esc_attr($redux_ThemeTek['tek-header-title']); ?></h1>
               <span class="intro-heading" style="color:<?php echo esc_attr($redux_ThemeTek['tek-header-color']); ?>"><?php echo esc_attr($redux_ThemeTek['tek-header-subtitle']); ?></span>
               <?php  if ($redux_ThemeTek['tek-header-type'] != 'subscribe-form') { ?>
               <div class="header-buttons">
                  <?php  if ($redux_ThemeTek['tek-header-button1text']) { ?>    <a href="<?php echo esc_url($redux_ThemeTek['tek-header-button1url']); ?>" class="primary-button"><?php echo esc_attr($redux_ThemeTek['tek-header-button1text']); ?></a><?php  } ?>
                  <?php  if ($redux_ThemeTek['tek-header-button2text']) { ?>    <a href="<?php echo esc_url($redux_ThemeTek['tek-header-button2url']); ?>" class="secondary-button page-scroll hidden-xs"><?php echo esc_attr($redux_ThemeTek['tek-header-button2text']); ?></a><?php  } ?>
               </div>
               <?php } else if ($redux_ThemeTek['tek-header-subscribe'])  echo do_shortcode( '[contact-form-7 id="'. esc_attr($redux_ThemeTek['tek-header-subscribe']) .'"]' ); ?>
            </div>
            <?php  if ($redux_ThemeTek['tek-header-type'] != 'subscribe-form') { ?>
            <div class="header-dashboard"> 
               <img src="<?php  echo esc_url($redux_ThemeTek['tek-header']['url']);  ?>" class="dashboard" alt="">
            </div>
            <?php } ?>
         </div>
         <?php if ($redux_ThemeTek['tek-particles']) { ?>
         <div id="particles-js"></div>
         <?php } ?>
         <div id="headerbackground">
            <?php if ($redux_ThemeTek['tek-bgimage']['url']) { echo " <div class='image-overlay' style='background-image: url(" . esc_url($redux_ThemeTek['tek-bgimage']['url']) . ")'></div>";}?>
         </div>
      </header>
      <?php } else { $themetek_header_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', false )  ?>      
      <header id="header" class="blog-header" style="background-image:url('<?php echo esc_url($themetek_header_image[0]); ?>')">
         <div class="header-overlay"></div>
         <div class="container">
            <div class="intro-text">
               <?php  if ( is_category() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('Currently browsing', 'keysoft')  ?>: <?php  single_cat_title(); ?>
               </h2>
               <?php } elseif ( is_search() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('Search result for', 'keysoft')  ?>: <?php  the_search_query();  ?>
               </h2>
               <?php } elseif ( is_tag() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('All posts tagged', 'keysoft')  ?>: <?php  single_tag_title(); ?>
               </h2>
               <?php } elseif ( is_author() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('All posts by', 'keysoft')  ?> <?php  echo esc_attr(get_userdata(get_query_var('author'))->display_name); ?>
               </h2>
               <?php } elseif ( is_day() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('Posts archive for', 'keysoft')  ?> <?php  echo get_the_date('F jS, Y'); ?>
               </h2>
               <?php } elseif ( is_month() ) { ?>
               <h2 class="section-heading">
                  <?php  esc_html_e('Posts archive for', 'keysoft')  ?> <?php  echo get_the_date('F, Y'); ?>
               </h2>
               <?php } elseif ( is_year() ) { ?>
               <h2 class="section-heading">
               <?php  esc_html_e('Posts archive for', 'keysoft')  ?> <?php  echo get_the_date('Y'); ?>
               </h2>
               <?php } elseif ( is_home() ) { ?>
               <h2 class="section-heading">
                  <?php echo get_bloginfo( 'name' ); ?>
               </h2>
               <?php  } else { ?>
               <h2 class="section-heading"><?php echo esc_html(get_the_title(get_queried_object_id())); ?></h2>
               <?php  } ?>
               <span class="separator" style="background:<?php echo esc_attr($redux_ThemeTek['tek-header-color']); ?>"></span>
               <p class="section-subheading" style="color:<?php echo esc_attr($redux_ThemeTek['tek-header-color']); ?>"><?php $themetek_page_subtitle = get_post_meta( get_the_ID(), '_themetek_page_subtitle', true ); echo $themetek_page_subtitle; ?> </p>
            </div>
         </div>
      </header>
      <?php } ?>