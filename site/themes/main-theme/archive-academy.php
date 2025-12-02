<?php get_header(); ?>

<?php
// Settings for the archive header
$page_title  = "أكاديميات القادة للخدمات الرياضية";
$page_sub    = "استكشف جميع الأكاديميات الرياضية وفروع التدريب المتوفرة لدينا";
$title_color = "#FFD700"; // Gold
$bg_color    = "#0E0E0E"; // Black
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="academy-archive-banner">
    <div class="container text-center">
        <h1 class="archive-title pt-5"
            style="color:<?php echo esc_attr($title_color); ?>; font-size:42px; font-weight:700;">
            <?php echo esc_html($page_title); ?>
        </h1>
        <p class="archive-subtitle text-white mt-3" style="opacity:0.85;">
            <?php echo esc_html($page_sub); ?>
        </p>
    </div>
</section>

<!-- ==================== ACADEMY GRID (CARD STYLE) ==================== -->
<section class="ls-academies js-scroll-up" style="background: <?php echo esc_attr($bg_color); ?>;">
    <div class="container">

        <div class="row justify-content-center">

            <?php if (have_posts()) : ?>

                <?php
                $delay = 0;

                while (have_posts()) :
                    the_post();

                    // Label (same logic as flex block)
                    $label = function_exists('get_field') ? (string) get_field('academy_label') : '';

                    if ($label === '') {
                        $terms = get_the_terms(get_the_ID(), 'academy_category');
                        if (!empty($terms) && !is_wp_error($terms)) {
                            $label = (string) $terms[0]->name;
                        }
                    }

                    if ($label === '') {
                        $label = get_the_title();
                    }

                    // Excerpt / short description
                    $excerpt = function_exists('get_field') ? (string) get_field('short_description') : '';
                    if ($excerpt === '') {
                        $excerpt = get_the_excerpt();
                    }

                    $delay += 0.2;
                ?>

                    <div class="col-md-4 col-sm-12 mb-4 academy-item"
                        data-delay="<?php echo esc_attr($delay); ?>">

                        <article <?php post_class('academy-card h-100'); ?>>

                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>"
                                    class="academy-thumb" style="background-color:transparent;"
                                    aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                    <?php
                                    the_post_thumbnail(
                                        'medium_large',
                                        array(
                                            'class'   => 'img-fluid',
                                            'loading' => 'lazy',
                                        )
                                    );
                                    ?>

                                    <?php if (!empty($label)) : ?>
                                        <span class="academy-label">
                                            <?php echo esc_html($label); ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            <?php else : ?>
                                <a href="<?php the_permalink(); ?>"
                                    class="academy-thumb academy-thumb--noimg"
                                    aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                    <?php if (!empty($label)) : ?>
                                        <span class="academy-label">
                                            <?php echo esc_html($label); ?>
                                        </span>
                                    <?php endif; ?>
                                </a>
                            <?php endif; ?>

                            <div class="academy-body">

                                <h3 class="academy-title" style="background-color:transparent">
                                    <a style="background-color:transparent" href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (!empty($excerpt)) : ?>

                                    <p class="academy-excerpt">
                                        <a style="background-color:transparent" href="<?php the_permalink(); ?>">
                                            <?php echo wp_kses_post($excerpt); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>

                            </div><!-- /.academy-body -->

                        </article><!-- /.academy-card -->

                    </div><!-- /.col -->

                <?php endwhile; ?>

                <!-- PAGINATION -->
                <div class="col-12 text-center mt-4">
                    <div class="pagination-wrapper">
                        <?php
                        echo paginate_links(array(
                            'mid_size'  => 2,
                            'prev_text' => __('« السابق', 'leaderssports'),
                            'next_text' => __('التالي »', 'leaderssports'),
                        ));
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <div class="col-12 text-center text-muted py-4">
                    <p><?php esc_html_e('لا توجد أكاديميات متاحة حالياً.', 'leaderssports'); ?></p>
                </div>

            <?php endif; ?>

        </div><!-- /.row -->

    </div><!-- /.container -->
</section>

<?php get_footer(); ?>