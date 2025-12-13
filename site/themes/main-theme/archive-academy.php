<?php get_header(); ?>

<?php
// ==================== ARCHIVE HEADER SETTINGS ====================
$page_title = __('أكاديميات القادة للخدمات الرياضية', 'leaderssports');
$page_sub   = __('استكشف جميع الأكاديميات الرياضية وفروع التدريب المتوفرة لدينا', 'leaderssports');

$title_color = '#FFD700'; // Gold
$bg_color    = '#0E0E0E'; // Black
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

<!-- ==================== ACADEMY GRID ==================== -->
<section class="ls-academies js-scroll-up" style="background: <?php echo esc_attr($bg_color); ?>;">
    <div class="container">
        <div class="row justify-content-center">

            <?php if (have_posts()) : ?>

                <?php
                $delay = 0;
                while (have_posts()) :
                    the_post();

                    // Label: ACF > taxonomy > title fallback
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

                    // Short description
                    $excerpt = function_exists('get_field') ? (string) get_field('short_description') : '';
                    if ($excerpt === '') {
                        $excerpt = get_the_excerpt();
                    }

                    $delay += 0.2;
                ?>

                    <div class="col-md-4 col-sm-12 mb-4 academy-item"
                        data-delay="<?php echo esc_attr($delay); ?>">

                        <article <?php post_class('academy-card h-100'); ?>>

                            <a href="<?php the_permalink(); ?>"
                                class="academy-thumb <?php echo has_post_thumbnail() ? '' : 'academy-thumb--noimg'; ?>"
                                aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                <?php
                                if (has_post_thumbnail()) {
                                    the_post_thumbnail(
                                        'medium_large',
                                        [
                                            'class'   => 'img-fluid',
                                            'loading' => 'lazy',
                                        ]
                                    );
                                }
                                ?>

                                <?php if (!empty($label)) : ?>
                                    <span class="academy-label">
                                        <?php echo esc_html($label); ?>
                                    </span>
                                <?php endif; ?>

                            </a>

                            <div class="academy-body">

                                <h3 class="academy-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (!empty($excerpt)) : ?>
                                    <p class="academy-excerpt">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo wp_kses_post($excerpt); ?>
                                        </a>
                                    </p>
                                <?php endif; ?>

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
                            'prev_text' => __('« السابق', 'leaderssports'),
                            'next_text' => __('التالي »', 'leaderssports'),
                        ]);
                        ?>
                    </div>
                </div>

            <?php else : ?>

                <div class="col-12 text-center text-muted py-4">
                    <p><?php esc_html_e('لا توجد أكاديميات متاحة حالياً.', 'leaderssports'); ?></p>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>