<?php 
   $redux_ThemeTek = get_option( 'redux_ThemeTek' );
   $themetek_page_subtitle = get_post_meta( get_the_ID(), '_themetek_page_subtitle', true ); 
   $themetek_page_showhide_title = get_post_meta( get_the_ID(), '_themetek_page_showhide_title', true );
    get_header();
?>
<section id="single-page" class="section <?php echo esc_attr($post->post_name);?>">
   <div class="container" >
      <div class="row single-page-content">
         <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
         <?php the_content(); ?>
         <?php comments_template('', true); ?>
         <?php endwhile; else: ?>
         <p><?php _e('Sorry, this page does not exist.', 'keysoft'); ?></p>
         <?php endif; ?>
      </div>
   </div>
</section>
<?php get_footer();?>