<?php

/**
 * Flexible Layout: Show Academies (Equal Images + Gray Hover)
 */

if (get_sub_field('visible')):

    $title          = get_sub_field('title');
    $subtitle       = get_sub_field('subtitle');
    $bg_color       = get_sub_field('background_color') ?: '#0E0E0E';
    $title_color    = get_sub_field('title_color') ?: '#FFD700';
?>

    <section class="ls-academies" style="background: <?php echo esc_attr($bg_color); ?>;">
        <div class="container">

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

            <div class="row justify-content-center">
                <?php
                $academies = new WP_Query(array(
                    'post_type'      => 'academy',
                    'posts_per_page' => 6,
                    'post_status'    => 'publish',
                    'orderby' => 'ID',
                    'order'   => 'ASC',
                ));

                if ($academies->have_posts()):
                    $delay = 0;
                    while ($academies->have_posts()): $academies->the_post(); ?>
                        <div class="col-md-4 col-sm-12 mb-4 academy-item" data-delay="<?php echo $delay; ?>">
                            <div class="academy-card">
                                <?php if (has_post_thumbnail()): ?>
                                    <a href="<?php the_permalink(); ?>" class="academy-thumb">
                                        <?php the_post_thumbnail('medium_large', ['class' => 'img-fluid']); ?>
                                    </a>
                                <?php endif; ?>
                                <h3 class="academy-title text-center mt-3">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h3>
                            </div>
                        </div>
                    <?php
                        $delay += 0.2;
                    endwhile;
                    wp_reset_postdata();
                else: ?>
                    <div class="col-12 text-center text-muted">
                        <p><?php esc_html_e('No academies found at the moment.', 'leaderssports'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

<?php endif; ?>