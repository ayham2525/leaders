<?php

/**
 * Flexible Layout: Show Tryouts – Professional Slider (Swiper)
 */

if (get_sub_field('visible')):

    $title       = get_sub_field('title');
    $subtitle    = get_sub_field('sub_title');
    $bg_color    = get_sub_field('background_color') ?: '#0E0E0E';
    $title_color = get_sub_field('title_color') ?: '#FFD700';
?>

    <section class="ls-tryouts-slider" style="background: <?php echo esc_attr($bg_color); ?>;">
        <div class="container">

            <!-- SECTION HEAD -->
            <?php if ($title || $subtitle): ?>
                <div class="section-head text-center mb-5">
                    <?php if ($title): ?>
                        <h2 class="section-title" style="color: <?php echo esc_attr($title_color); ?>;">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <p class="section-subtitle"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>


            <!-- SWIPER SLIDER -->
            <div class="swiper tryouts-swiper">
                <div class="swiper-wrapper">

                    <?php
                    $tryouts = new WP_Query(array(
                        'post_type'      => 'tryout',
                        'posts_per_page' => -1,
                        'post_status'    => 'publish',
                        'orderby'        => 'ID',
                        'order'          => 'ASC',
                    ));

                    if ($tryouts->have_posts()):
                        while ($tryouts->have_posts()): $tryouts->the_post();
                    ?>

                            <div class="swiper-slide">
                                <div class="tryout-card">

                                    <!-- IMAGE -->
                                    <a href="<?php the_permalink(); ?>" class="tryout-thumb">
                                        <?php if (has_post_thumbnail()): ?>
                                            <?php the_post_thumbnail('large', ['class' => 'img-fluid']); ?>
                                        <?php endif; ?>
                                    </a>

                                    <!-- TITLE OVER IMAGE -->
                                    <h3 class="tryout-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                </div>
                            </div>

                    <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>

                </div>

                <!-- NAVIGATION -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- PAGINATION -->
                <div class="swiper-pagination d-none"></div>
            </div>

        </div>
    </section>

<?php endif; ?>