<?php
   if (post_password_required()) {
       return;
   }   
?>
<div id="comments" class="comments-area">
   <?php if (have_comments()): ?>
   <div class="reply-title">Comments</div>
   <?php if (get_comment_pages_count() > 1 && get_option('page_comments')): ?>
   <nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
      <h1 class="screen-reader-text"><?php _e('Comment navigation', 'keysoft'); ?></h1>
      <div class="nav-previous"><?php previous_comments_link(esc_html__('&larr; Older Comments', 'keysoft')); ?></div>
      <div class="nav-next"><?php next_comments_link(esc_html__('Newer Comments &rarr;', 'keysoft')); ?></div>
   </nav>
   <?php endif; ?>
   <ul class="comment-list">
      <?php
         wp_list_comments(array(
             'style' => 'ul',
             'short_ping' => true,
             'avatar_size' => 70
         ));
      ?>
   </ul>
   <?php
      if (get_comment_pages_count() > 1 && get_option('page_comments')):
      ?>
   <nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
      <h1 class="screen-reader-text"><?php
         _e('Comment navigation', 'keysoft');
         ?></h1>
      <div class="nav-previous"><?php
         previous_comments_link(esc_html__('&larr; Older Comments', 'keysoft'));
         ?></div>
      <div class="nav-next"><?php
         next_comments_link(esc_html__('Newer Comments &rarr;', 'keysoft'));
         ?></div>
   </nav>
   <?php
      endif; 
      ?>
   <?php
      if (!comments_open()):
      ?>
   <p class="no-comments"><?php
      _e('Comments are closed.', 'keysoft');
      ?></p>
   <?php
      endif;
      ?>
   <?php
      endif;
      ?>
   <?php
      $themetek_commenter     = wp_get_current_commenter();
      $keysoft_args          = array(
          'id_form' => 'commentform',
          'id_submit' => 'submit',
          'title_reply' => esc_html__('Leave a comment', 'keysoft'),
          'title_reply_to' => esc_html__('Leave a Reply to %s', 'keysoft'),
          'cancel_reply_link' => esc_html__(' - Cancel Reply', 'keysoft'),
          'label_submit' => esc_html__('Post a Comment', 'keysoft'),
          'comment_field' => '<p class="comment-form-comment"><textarea placeholder="Comment" id="comment" name="comment" cols="45" rows="8" aria-required="true">' . '</textarea></p>',
          'comment_notes_after' => '',
          'fields' => apply_filters('comment_form_default_fields', array(
              'author' => '<p class="comment-form-author"><input placeholder="Name" id="author" name="author" type="text" value="' . esc_attr($themetek_commenter['comment_author']) . '" size="30" /></p>',
              'email' => '<p class="comment-form-email"><input placeholder="Email" id="email" name="email" type="text" value="' . esc_attr($themetek_commenter['comment_author_email']) . '" size="30" /></p>'
          ))
      );
      comment_form($keysoft_args, get_the_ID());
      ?> 
</div>
