<?php 
   $redux_ThemeTek = get_option( 'redux_ThemeTek' );
   get_header();
   ?>
<?php  if( is_home() ) : ?>
<div id="posts-content"  class="container" >
   <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
      <?php 
         if (have_posts()) :
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
            <?php wp_link_pages(); ?>
         </div>
         <div class="more-button"><a href="<?php  esc_url(the_permalink()); ?>" title="<?php  printf(esc_html__('Permanent link to %s', 'keysoft'), get_the_title()); ?>" class="simple-button">Learn More</a></div>
      </div>
      <?php  endwhile; ?>
      <?php  the_posts_pagination( array('mid_size' => 1,'prev_text' => esc_html__( 'Previous', '' ),'next_text' => esc_html__( 'Next', '' ),) ); ?>
   </div>
   <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
      <?php  get_sidebar(); ?>
   </div>
</div>
<?php  else : ?>
<div id="posts-content"  class="container" >
   <div id="post-not-found" <?php  post_class(); ?>>
      <h2 class="entry-title"><?php  _e('Error 404 - Not Found', 'keysoft')      ?></h2>
      <div class="entry-content">
         <p><?php  _e("Sorry, no posts matched your criteria.", "keysoft")      ?></p>
      </div>
   </div>
</div>
<?php  endif; ?>
<?php  else : ?>
<?php
   $keysoft_homePageID=get_the_ID();
   $keysoft_args=array('post_type'=>'page','posts_per_page'=>-1,'post_parent'=>$keysoft_homePageID,'post__not_in'=>array($keysoft_homePageID),'order'=>'ASC','orderby'=>'menu_order');
   $keysoft_parent=new WP_Query($keysoft_args);
   ?>
<?php  if($keysoft_parent->have_posts()): ?>
<?php 
   while($keysoft_parent->have_posts()):
   $keysoft_parent->the_post();
   ?>
<?php  $keysoft_page_template=str_replace('page_','',str_replace('.php','',basename(get_page_template()))); ?>
<?php  if($keysoft_page_template&&$keysoft_page_template!='page'): ?>
<?php  get_template_part($keysoft_page_template,get_post_format()); ?>
<?php  wp_reset_postdata(); ?>
<?php  else : ?>
<?php  get_template_part('loop',get_post_format()); ?>
<?php  wp_reset_postdata(); ?>
<?php  endif; ?>
<?php  endwhile; ?>
<?php  endif; ?>
<?php  endif; ?>
<?php  get_footer(); ?>