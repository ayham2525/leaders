<?php

/**
 * Flexible Layout: Show Sports Activities (Equal Images + Gold Hover)
 */

if (get_sub_field('visible')):

    $title        = get_sub_field('title');
    $subtitle     = get_sub_field('sub_title');
    $bg_color     = get_sub_field('background_color') ?: '#0E0E0E';
    $title_color  = get_sub_field('title_color') ?: '#FFD700';
?>

    <section class="ls-sports-activities" style="background: <?php echo esc_attr($bg_color); ?>;">
        <div class="container">

            <?php if ($title || $subtitle): ?>
                <div class="section-head text-center mb-5">
                    <?php if ($title): ?>
                        <h2 class="section-title" style="color: <?php echo esc_attr($title_color); ?>;">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($subtitle): ?>
                        <p class="section-subtitle text-white"><?php echo esc_html($subtitle); ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">

                <?php
                $activities = new WP_Query([
                    'post_type'      => 'sports_activity',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'orderby'        => 'ID',
                    'order'          => 'ASC',
                ]);

                if ($activities->have_posts()):
                    $delay = 0;
                    while ($activities->have_posts()): $activities->the_post(); ?>

                        <div class="col-md-4 col-sm-12 mb-4 sport-item" data-delay="<?php echo $delay; ?>">
                            <div class="sport-inner">

                                <div class="sport-card">

                                    <?php if (has_post_thumbnail()): ?>
                                        <a href="<?php the_permalink(); ?>" class="sport-thumb">
                                            <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                            <div class="thumb-overlay"></div>
                                        </a>
                                    <?php endif; ?>

                                    <h3 class="sport-title text-center mt-3">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                </div>
                            </div>
                        </div>

                    <?php
                        $delay += 0.15;
                    endwhile;

                    wp_reset_postdata();

                else: ?>
                    <div class="col-12 text-center text-muted">
                        <p><?php esc_html_e('No sports activities available at the moment.', 'leaderssports'); ?></p>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </section>

<?php endif; ?>