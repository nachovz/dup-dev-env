<?php
   /**
   * The template for displaying 404 pages (Not Found)
   */
   get_header(); ?>
<section class="container page-404">
   <div class="row" >
      <h2 class="section-heading"><?php  echo esc_attr($redux_ThemeTek['tek-404-title'])  ?></h2>
      <span class="separator"></span>
      <p class="section-subheading"><?php  echo esc_attr($redux_ThemeTek['tek-404-subtitle']) ?></p>
      <a href="<?php echo esc_url(get_site_url()); ?>" class="secondary-button secondary-button-inverse"><?php  echo esc_attr($redux_ThemeTek['tek-404-back'])  ?></a>
   </div>
</section>
<?php  get_footer(); ?>