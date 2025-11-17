<?php  /* Template Name: Main Theme */ ?>

<?php
get_header(); ?>
<div id="main_container" class="site-main" role="main" <?php if (!is_front_page()): ?> <?php endif; ?>>
  <?php
  if (have_rows('main_content')) :
    while (have_rows('main_content')) : the_row();
  ?>

  <?php
      get_template_part('partials/' . get_row_layout());

    endwhile;
  endif;
  ?>
</div><!-- #main -->

<?php
get_footer();
