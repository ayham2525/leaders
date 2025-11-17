<?php get_header(); ?>

<?php
// PAGE SETTINGS (you can change if needed)
$bg_color    = '#0E0E0E';
$title_color = '#FFD700';
$page_title  = 'الأنشطة الرياضية';
$page_sub    = 'تعرف على كافة برامج التدريب الرياضي لدينا';
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="sports-archive-banner" style="background:#111; padding:70px 0;">
    <div class="container text-center">
        <h1 class="archive-title pt-5" style="color:<?php echo $title_color; ?>; font-size:42px; font-weight:700;">
            <?php echo esc_html($page_title); ?>
        </h1>
        <p class="archive-subtitle text-white mt-3" style="opacity:0.8;">
            <?php echo esc_html($page_sub); ?>
        </p>
    </div>
</section>

<!-- ==================== SPORTS ACTIVITIES GRID ==================== -->
<section class="ls-sports-activities" style="background: <?php echo esc_attr($bg_color); ?>;">
    <div class="container">

        <div class="row justify-content-center">

            <?php if (have_posts()): ?>
                <?php $delay = 0; ?>

                <?php while (have_posts()): the_post(); ?>

                    <div class="col-md-4 col-sm-12 mb-4 sport-item" data-delay="<?php echo $delay; ?>">
                        <div class="sport-card">

                            <div class="sport-inner">

                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>" class="sport-thumb">
                                        <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                        <div class="thumb-overlay"></div>
                                    </a>
                                <?php endif; ?>

                            </div>

                            <h3 class="sport-title text-center mt-3">
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
                <div class="col-12 text-center text-muted">
                    <p><?php esc_html_e('لا توجد أنشطة رياضية متاحة حالياً.', 'leaderssports'); ?></p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>