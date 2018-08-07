<?php
   get_header(); ?>
<?php  if ( have_posts() ) : ?>
<div id="posts-content"  class="container" >
<?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
   <?php } else { ?>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <?php } ?>
      <?php 
         while (have_posts()) :
         the_post();
         ?>
      <div <?php  post_class('section'); ?> id="post-<?php  the_ID(); ?>" >
         <?php  the_post_thumbnail('large'); ?>
         <a href="<?php esc_url(the_permalink()); ?>" title="<?php the_title_attribute(); ?>"><h2 class="blog-single-title"><?php  the_title(); ?></h2></a>
          <div class="entry-meta">
            <?php  if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
            <span class="published"><?php  the_time( get_option('date_format') ); ?></span><span class="blog-separator">|</span>
            <span class="author"><?php  the_author_posts_link(); ?></span><span class="blog-separator">|</span>                   
            <span class="blog-label">in category <?php  the_category(', '); ?></span>                    
            <span class="comment-count"><span class="fa fa-comment-o"></span><?php  comments_popup_link( esc_html__('No comments yet', 'keysoft'), esc_html__('1 comment', 'keysoft'), esc_html__('% comments', 'keysoft') ); ?></span>
         </div>
         <div class="entry-content">
            <?php  if(has_excerpt()) : ?>
            <?php  the_excerpt(); ?>
            <?php  else : ?>
            <div class="page-content"><?php  the_content(); ?></div>
            <?php  endif; ?>
         </div>
         <div class="more-button"><a href="<?php  esc_url(the_permalink()); ?>" title="<?php  printf(esc_html__('Permanent link to %s', 'keysoft'), get_the_title()); ?>" class="simple-button">Learn More</a></div>
      </div>
      <?php  endwhile; ?>
      <?php  the_posts_pagination( array('mid_size' => 1,'prev_text' => esc_html__( 'Previous', '' ),'next_text' => esc_html__( 'Next', '' ),) ); ?>
   </div>
   <?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <?php  get_sidebar(); ?>
   </div>
   <?php } ?>
</div>
<?php  else : ?>
<div id="posts-content"  class="container" >
   <h2 class="section-title"><?php  _e( 'Nothing Found', 'keysoft' ); ?></h2>
   <?php  if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
   <p><?php  printf( esc_html__( 'Ready to publish your first post?', 'keysoft' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
   <?php  elseif ( is_search() ) : ?>
   <p><?php  _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'keysoft' ); ?></p>
   <?php  get_search_form(); ?>
   <?php  else : ?>
   <p><?php  _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'keysoft' ); ?></p>
   <?php  get_search_form(); ?>
   <?php  endif; ?>
</div>
<?php  endif; ?>
<?php  get_footer(); ?>
