<?php

/**
 * Flexible Layout: Show Sports Activities (Full-Width Hero Slider)
 */

if (get_sub_field('visible')) :

    $title       = get_sub_field('title');
    $subtitle    = get_sub_field('sub_title');
    $bg_color    = get_sub_field('background_color') ?: '#0E0E0E';
    $title_color = get_sub_field('title_color') ?: '#FFD700';

    // Query activities
    $activities = new WP_Query([
        'post_type'      => 'sports_activity',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'orderby'        => 'ID',
        'order'          => 'ASC',
    ]);
?>

    <section class="ls-sports-activities" style="background: <?php echo esc_attr($bg_color); ?>;">
        <div class="container-fluid px-0">

            <?php if ($title || $subtitle): ?>
                <div class="section-head text-center mb-4">
                    <?php if ($title): ?>
                        <h2 class="section-title" style="color: <?php echo esc_attr($title_color); ?>;">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <p class="section-subtitle text-white">
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($activities->have_posts()): ?>

                <div class="ls-sports-slider owl-carousel">
                    <?php while ($activities->have_posts()): $activities->the_post(); ?>

                        <?php
                        // اختياري: وصف قصير من ACF أو من الملخص
                        $excerpt = function_exists('get_field') ? (string) get_field('short_description') : '';
                        if ($excerpt === '') {
                            $excerpt = get_the_excerpt();
                        }
                        ?>

                        <div class="sport-slide">
                            <div class="sport-slide-inner">
                                <div class="row no-gutters align-items-stretch">

                                    <!-- النص / اسم النشاط -->
                                    <div class="col-lg-5 col-md-6">
                                        <div class="sport-text-panel">


                                            <h3 class="sport-name">
                                                <?php the_title(); ?>
                                            </h3>

                                            <?php if (!empty($excerpt)): ?>
                                                <p class="sport-desc">
                                                    <?php echo esc_html(wp_trim_words(wp_strip_all_tags($excerpt), 26, '…')); ?>
                                                </p>
                                            <?php endif; ?>

                                            <a href="<?php the_permalink(); ?>" class="sport-link">
                                                <?php esc_html_e('المزيد', 'leaderssports'); ?>
                                            </a>
                                        </div>
                                    </div>

                                    <!-- الصورة -->
                                    <div class="col-lg-7 col-md-6">
                                        <div class="sport-image-wrap">
                                            <?php if (has_post_thumbnail()): ?>
                                                <?php
                                                the_post_thumbnail(
                                                    'large',
                                                    [
                                                        'class'   => 'sport-image img-fluid',
                                                        'loading' => 'lazy',
                                                    ]
                                                );
                                                ?>
                                            <?php else: ?>
                                                <div class="sport-image sport-image--placeholder"></div>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div><!-- /.row -->
                            </div><!-- /.sport-slide-inner -->
                        </div><!-- /.sport-slide -->

                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div><!-- /.ls-sports-slider -->

            <?php else: ?>
                <div class="row justify-content-center">
                    <div class="col-12 text-center text-muted">
                        <p><?php esc_html_e('No sports activities available at the moment.', 'leaderssports'); ?></p>
                    </div>
                </div>
            <?php endif; ?>

        </div><!-- /.container-fluid -->
    </section>

<?php endif; ?>