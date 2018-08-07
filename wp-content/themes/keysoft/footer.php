<?php $redux_ThemeTek = get_option( 'redux_ThemeTek' ); ?>
</div>
<footer id="footer">
   <div class="container">
      <div class="lower-footer">
         <div class="pull-left">
            <span><?php  echo esc_html($redux_ThemeTek['tek-footer-text']) ?></span>
         </div>
         <div id="social-icons" class="pull-right">
            <?php  if ($redux_ThemeTek['tek-social-icons'][1] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-facebook-url'])  ?>" target="_blank"><span class="fa fa-facebook"></span></a><?php  endif  ?>
            <?php  if ($redux_ThemeTek['tek-social-icons'][2] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-twitter-url'])  ?>" target="_blank"><span class="fa fa-twitter"></span></a><?php  endif  ?>
            <?php  if ($redux_ThemeTek['tek-social-icons'][3] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-google-url'])  ?>" target="_blank"><span class="fa fa-google-plus"></span></a><?php  endif  ?>
            <?php  if ($redux_ThemeTek['tek-social-icons'][4] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-pinterest-url'])  ?>" target="_blank"><span class="fa fa-pinterest"></span></a><?php  endif  ?>
            <?php  if ($redux_ThemeTek['tek-social-icons'][5] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-youtube-url'])  ?>" target="_blank"><span class="fa fa-youtube"></span></a><?php  endif  ?>
            <?php  if ($redux_ThemeTek['tek-social-icons'][6] == 1): ?><a href="<?php  echo esc_url($redux_ThemeTek['tek-linkedin-url'])  ?>" target="_blank"><span class="fa fa-linkedin"></span></a><?php  endif  ?>
         </div>
      </div>
   </div>
</footer>
<?php  wp_footer(); ?>
</body>
</html>