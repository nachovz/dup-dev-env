<?php 
   get_header();
?>
<div id="posts-content" class="container blog-single">
<?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
   <?php } else { ?>
   <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <?php } ?>
      <?php 
         if (have_posts()) :
         while (have_posts()) :
         the_post();
         ?>
      <div <?php  post_class(); ?> id="post-<?php  the_ID(); ?>">
         <div class="blog-single-content">
            <?php the_post_thumbnail('large'); ?>
            <h1 class="blog-single-title"><?php  the_title(); ?></h1>
          <div class="entry-meta">
            <?php  if ( is_sticky() ) echo '<span class="fa fa-thumb-tack"></span> Sticky <span class="blog-separator">|</span>  '; ?>
            <span class="published"><?php  the_time( get_option('date_format') ); ?></span><span class="blog-separator">|</span>
            <span class="author"><?php  the_author_posts_link(); ?></span><span class="blog-separator">|</span>                   
            <span class="blog-label">in category <?php  the_category(', '); ?></span>                    
            <span class="comment-count"><span class="fa fa-comment-o"></span><?php  comments_popup_link( esc_html__('No comments yet', 'keysoft'), esc_html__('1 comment', 'keysoft'), esc_html__('% comments', 'keysoft') ); ?></span>
         </div>
            <div class="blog-content"><?php the_content(); ?><?php wp_link_pages(); ?></div>
            <div class="meta-content">
               <div class="tags"><?php the_tags(' ',' '); ?></div>
               <div class="navigation pagination">
                  <?php previous_post_link('%link', 'Previous'); ?>
                  <?php next_post_link('%link', 'Next'); ?>
               </div>
            </div>
         </div>
      </div>
      <div class="page-content comments-content">
         <?php comments_template('', true); ?>
      </div>
   </div>
   <?php if ($redux_ThemeTek['tek-blog-sidebar']) { ?>
   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <?php  get_sidebar(); ?>
   </div>
   <?php } ?>
   <?php  endwhile; ?>
   <?php  else : ?>
   <div id="post-not-found" <?php  post_class()   ?>>
      <h1 class="entry-title"><?php  _e('Error 404 - Not Found', 'keysoft')   ?></h1>
      <div class="entry-content">
         <p><?php  _e("Sorry, but you are looking for something that isn't here.", "keysoft")   ?></p>
      </div>
   </div>
   <?php  endif; ?>
</div>
<?php  get_footer(); ?>
