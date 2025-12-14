<?php get_header(); ?>

<?php
// ==================== ARCHIVE PAGE SETTINGS ====================
$page_title  = __('Latest News', 'main-theme');
$page_sub    = __('Stay updated with the latest sports news and events from Leaders Sports', 'main-theme');
$title_color = '#FFD700'; // Gold
$bg_color    = '#0E0E0E'; // Black
?>

<!-- ==================== ARCHIVE BANNER ==================== -->
<section class="news-archive-banner" style="background:#111; padding:70px 0;">
    <div class="container text-center">
        <h1 class="archive-title pt-5"
            style="color:<?php echo esc_attr($title_color); ?>; font-size:42px; font-weight:700;">

            <?php
            $archive_title = single_cat_title('', false);
            echo esc_html($archive_title ? $archive_title : $page_title);
            ?>
        </h1>

        <?php if (is_category() || is_tag() || is_search()) : ?>
            <p class="archive-subtitle text-white mt-2" style="opacity:0.8;">
                <?php echo esc_html(term_description() ?: $page_sub); ?>
            </p>
        <?php else : ?>
            <p class="archive-subtitle text-white mt-2" style="opacity:0.8;">
                <?php echo esc_html($page_sub); ?>
            </p>
        <?php endif; ?>
    </div>
</section>

<!-- ==================== POSTS GRID ==================== -->
<section class="ls-news-archive py-5" style="background:<?php echo esc_attr($bg_color); ?>;">
    <div class="container">
        <div class="row">

            <?php if (have_posts()) : ?>
                <?php $delay = 0; ?>

                <?php while (have_posts()) : the_post(); ?>

                    <div class="col-md-4 col-sm-12 mb-4 news-item"
                        data-delay="<?php echo esc_attr($delay); ?>">

                        <div class="news-card">
                            <a href="<?php the_permalink(); ?>"
                                class="news-thumb"
                                aria-label="<?php echo esc_attr(get_the_title()); ?>">

                                <?php if (has_post_thumbnail()) : ?>
                                    <?php
                                    the_post_thumbnail(
                                        'medium_large',
                                        ['class' => 'img-fluid', 'loading' => 'lazy']
                                    );
                                    ?>
                                <?php else : ?>
                                    <img
                                        src="<?php echo esc_url(get_template_directory_uri() . '/assets/img/no-image.jpg'); ?>"
                                        class="img-fluid"
                                        alt="<?php esc_attr_e('No image available', 'main-theme'); ?>">
                                <?php endif; ?>

                                <div class="thumb-overlay"></div>
                            </a>

                            <h3 class="news-title">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                            </h3>

                            <p class="news-excerpt text-white">
                                <?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?>
                            </p>

                            <div class="news-meta text-white mb-3">
                                <i class="las la-calendar"></i>
                                <?php echo esc_html(get_the_date()); ?>
                            </div>

                            <a class="btn btn-news-read" href="<?php the_permalink(); ?>">
                                <?php esc_html_e('Read More', 'main-theme'); ?>
                            </a>
                        </div>
                    </div>

                    <?php $delay += 0.15; ?>

                <?php endwhile; ?>

                <!-- PAGINATION -->
                <div class="col-12 text-center mt-4">
                    <?php
                    echo paginate_links([
                        'mid_size'  => 2,
                        'prev_text' => __('« Previous', 'main-theme'),
                        'next_text' => __('Next »', 'main-theme'),
                    ]);
                    ?>
                </div>

            <?php else : ?>

                <div class="col-12 text-center text-muted py-5">
                    <p><?php esc_html_e('No articles available at the moment.', 'main-theme'); ?></p>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>

<?php get_footer(); ?>