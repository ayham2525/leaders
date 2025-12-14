<?php
get_header();

// ==================== PAGE SETTINGS ====================
$bg_color    = '#0E0E0E';
$title_color = '#FFD700';

// English is the main language
$page_title     = __('Sports Activities', 'main-theme');
$page_sub       = __('Discover all our sports training programs', 'main-theme');
$badge_label    = __('Leaders Sports', 'main-theme');
$tag_label      = __('Sports Program', 'main-theme');
$discover_label = __('Discover Program Details', 'main-theme');
$no_sports_text = __('No sports activities available at the moment.', 'main-theme');
$prev_label     = __('« Previous', 'main-theme');
$next_label     = __('Next »', 'main-theme');

$dir_attr = is_rtl() ? 'rtl' : 'ltr';
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="sports-archive-banner js-scroll-up" dir="<?php echo esc_attr($dir_attr); ?>">
    <div class="container">
        <div class="sports-archive-banner__inner">
            <div class="sports-archive-banner__content">

                <h1 class="archive-title">
                    <?php echo esc_html($page_title); ?>
                </h1>

                <p class="archive-subtitle">
                    <?php echo esc_html($page_sub); ?>
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
                    $delay   += 0.15;
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
                                        [
                                            'class'    => 'sport-thumb__img',
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                        ]
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

                                <?php if (!empty($excerpt)) : ?>
                                    <p class="sport-excerpt">
                                        <?php echo esc_html($excerpt); ?>
                                    </p>
                                <?php endif; ?>

                                <a href="<?php the_permalink(); ?>" class="sport-readmore">
                                    <span><?php echo esc_html($discover_label); ?></span>
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
                        echo paginate_links([
                            'mid_size'  => 2,
                            'prev_text' => esc_html($prev_label),
                            'next_text' => esc_html($next_label),
                        ]);
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <div class="col-12 text-center text-muted py-5">
                    <p><?php echo esc_html($no_sports_text); ?></p>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>