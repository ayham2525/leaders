<?php
get_header();

// PAGE SETTINGS (translation-ready)
$bg_color       = '#0E0E0E';
$title_color    = '#FFD700';

$page_title     = esc_html__('الفعاليات الرياضية', 'leaderssports');
$page_sub       = esc_html__('تعرف على كافة برامج التدريب الرياضي لدينا', 'leaderssports');
$badge_label    = esc_html__('ليدرز سبورتس', 'leaderssports');
$tag_label      = esc_html__('برنامج رياضي', 'leaderssports');
$discover_label = esc_html__('اكتشف تفاصيل البرنامج', 'leaderssports');
$no_sports_text = esc_html__('لا توجد أنشطة رياضية متاحة حالياً.', 'leaderssports');
$prev_label     = esc_html__('« السابق', 'leaderssports');
$next_label     = esc_html__('التالي »', 'leaderssports');
$dir_attr       = is_rtl() ? 'rtl' : 'ltr';
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="sports-archive-banner js-scroll-up" dir="<?php echo esc_attr($dir_attr); ?>">
    <div class="container">
        <div class="sports-archive-banner__inner">

            <div class="sports-archive-banner__content">


                <h1 class="archive-title">
                    <?php echo $page_title; ?>
                </h1>

                <p class="archive-subtitle">
                    <?php echo $page_sub; ?>
                </p>
            </div>

        </div>
    </div>
</section>

<!-- ==================== SPORTS ACTIVITIES GRID ==================== -->
<section class="ls-sports-activities js-scroll-up" dir="<?php echo esc_attr($dir_attr); ?>">
    <div class="container">
        <div class="row justify-content-center">

            <?php if (have_posts()) : ?>
                <?php $delay = 0; ?>

                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $delay   = ($delay ?? 0) + 0.15;
                    $excerpt = wp_trim_words(get_the_excerpt(), 20);
                    $date    = get_the_date();
                    ?>

                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4 sport-item js-scroll-up"
                        style="--delay: <?php echo esc_attr($delay); ?>s;">
                        <article <?php post_class('sport-card'); ?>>

                            <?php if (has_post_thumbnail()) : ?>
                                <a href="<?php the_permalink(); ?>"
                                    class="sport-thumb"
                                    aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                    <?php
                                    the_post_thumbnail(
                                        'medium_large',
                                        array(
                                            'class'    => 'sport-thumb__img',
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                        )
                                    );
                                    ?>

                                    <span class="sport-thumb__overlay" aria-hidden="true"></span>

                                    <span class="sport-tag">
                                        <?php echo esc_html($tag_label); ?>
                                    </span>
                                </a>
                            <?php endif; ?>

                            <div class="sport-body">
                                <div class="sport-meta">
                                    <span class="sport-meta__item">
                                        <i class="las la-calendar"></i>
                                        <?php echo esc_html($date); ?>
                                    </span>
                                </div>

                                <h3 class="sport-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (! empty($excerpt)) : ?>
                                    <p class="sport-excerpt">
                                        <?php echo esc_html($excerpt); ?>
                                    </p>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="sport-readmore">
                                    <span><?php echo $discover_label; ?></span>
                                    <i class="las la-arrow-left"></i>
                                </a>
                            </div>

                        </article>
                    </div>

                <?php endwhile; ?>

                <!-- PAGINATION -->
                <div class="col-12 text-center mt-4">
                    <div class="pagination-wrapper">
                        <?php
                        echo paginate_links(
                            array(
                                'mid_size'  => 2,
                                'prev_text' => $prev_label,
                                'next_text' => $next_label,
                            )
                        );
                        ?>
                    </div>
                </div>

            <?php else : ?>
                <div class="col-12 text-center text-muted py-5">
                    <p><?php echo $no_sports_text; ?></p>
                </div>
            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>