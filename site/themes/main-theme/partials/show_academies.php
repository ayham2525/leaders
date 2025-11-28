<?php

/**
 * Flexible Layout: Show Academies (Featured Cards Style)
 *
 * Displays up to 6 academy posts in a 3-column grid using a
 * card layout similar to a news / featured article block.
 *
 * ACF sub fields:
 * - visible (true/false)
 * - title
 * - subtitle
 * - background_color
 * - title_color
 */

if (function_exists('get_sub_field') && get_sub_field('visible')) :

    $title       = trim((string) get_sub_field('title'));
    $subtitle    = trim((string) get_sub_field('subtitle'));
    $bg_color    = get_sub_field('background_color') ?: '#f2f2f2';
    $title_color = get_sub_field('title_color') ?: '#D32F2F';

    // Query args (filterable if needed later).
    $query_args = apply_filters(
        'leaderssports/academies_query_args',
        array(
            'post_type'           => 'academy',
            'posts_per_page'      => 6,
            'post_status'         => 'publish',
            'orderby'             => 'ID',
            'order'               => 'ASC',
            'ignore_sticky_posts' => true,
            'no_found_rows'       => true,
        )
    );

    $academies = new WP_Query($query_args);
?>

    <section class="ls-academies js-scroll-up" style="background: <?php echo esc_attr($bg_color); ?>;">
        <div class="container">

            <?php if ($title || $subtitle) : ?>
                <div class="section-head text-center mb-5">
                    <?php if ($title) : ?>
                        <h2 class="section-title" style="color: <?php echo esc_attr($title_color); ?>;">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($subtitle) : ?>
                        <p class="section-subtitle">
                            <?php echo esc_html($subtitle); ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="row justify-content-center">
                <?php if ($academies->have_posts()) : ?>
                    <?php
                    $delay = 0;

                    while ($academies->have_posts()) :
                        $academies->the_post();

                        // Label (ACF field -> taxonomy -> fallback).
                        $label = function_exists('get_field') ? (string) get_field('academy_label') : '';

                        if ($label === '') {
                            $terms = get_the_terms(get_the_ID(), 'academy_category');
                            if (!empty($terms) && !is_wp_error($terms)) {
                                $label = (string) $terms[0]->name;
                            }
                        }

                        if ($label === '') {
                            $label =   get_the_title();
                        }

                        // Excerpt / short description.
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
                                        class="academy-thumb"
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

                                        <?php if ($label) : ?>
                                            <span class="academy-label">
                                                <?php echo esc_html($label); ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>"
                                        class="academy-thumb academy-thumb--noimg"
                                        aria-label="<?php echo esc_attr(get_the_title()); ?>">
                                        <?php if ($label) : ?>
                                            <span class="academy-label">
                                                <?php echo esc_html($label); ?>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>

                                <div class="academy-body">


                                    <h3 class="academy-title">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php the_title(); ?>
                                        </a>
                                    </h3>

                                    <?php if (!empty($excerpt)) : ?>
                                        <p class="academy-excerpt">
                                            <?php echo wp_kses_post($excerpt); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </article>
                        </div>
                    <?php endwhile; ?>

                    <?php wp_reset_postdata(); ?>

                <?php else : ?>
                    <div class="col-12 text-center text-muted">
                        <p><?php esc_html_e('No academies found at the moment.', 'leaderssports'); ?></p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </section>

<?php
endif;
?>