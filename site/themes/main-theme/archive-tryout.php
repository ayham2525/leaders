<?php get_header(); ?>

<?php
// Archive Page Settings
$page_title  = "تجارب الأداء";
$page_sub    = "استكشف جميع تجارب الأداء والاختبارات المتاحة للتسجيل";
$title_color = "#FFD700"; // Gold
$bg_color    = "#0E0E0E"; // Black
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="tryout-archive-banner" style="background:#111; padding:70px 0;">
    <div class="container text-center">
        <h1 class="archive-title pt-5" style="color:<?php echo $title_color; ?>; font-size:42px; font-weight:700;">
            <?php echo esc_html($page_title); ?>
        </h1>
        <p class="archive-subtitle text-white mt-3" style="opacity:0.85;">
            <?php echo esc_html($page_sub); ?>
        </p>
    </div>
</section>

<!-- ==================== TRYOUTS GRID ==================== -->
<section class="ls-tryouts py-5" style="background: <?php echo esc_attr($bg_color); ?>;">
    <div class="container">

        <div class="row justify-content-center">

            <?php if (have_posts()): ?>

                <?php $delay = 0; ?>

                <?php while (have_posts()): the_post(); ?>

                    <div class="col-md-4 col-sm-12 mb-4 tryout-item" data-delay="<?php echo $delay; ?>">

                        <div class="tryout-card">

                            <div class="tryout-thumb-wrapper">
                                <a href="<?php the_permalink(); ?>" class="tryout-thumb">
                                    <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                    <div class="thumb-overlay"></div>
                                </a>
                            </div>

                            <h3 class="tryout-title text-center mt-3">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>

                        </div>

                    </div>

                    <?php $delay += 0.15; ?>

                <?php endwhile; ?>

                <!-- PAGINATION -->
                <div class="col-12 text-center mt-4">
                    <div class="pagination-wrapper">
                        <?php
                        echo paginate_links([
                            'mid_size'  => 2,
                            'prev_text' => __('« السابق'),
                            'next_text' => __('التالي »'),
                        ]);
                        ?>
                    </div>
                </div>

            <?php else: ?>

                <div class="col-12 text-center text-muted py-4">
                    <p><?php esc_html_e('لا توجد تجارب أداء متاحة حالياً.', 'leaderssports'); ?></p>
                </div>

            <?php endif; ?>

        </div>

    </div>
</section>

<?php get_footer(); ?>