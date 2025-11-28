<?php

/**
 * ACF Flex Block: News Grid (4 small + 1 big)
 * Sub Fields: visible, background_color, title_color, title
 */

if (!function_exists('ls_bool')) {
    function ls_bool($v)
    {
        return ($v === true || $v === '1' || $v === 1 || $v === 'true');
    }
}

$visible = get_sub_field('visible');
if (!ls_bool($visible)) {
    return;
}

// Colors & title
$bg            = get_sub_field('background_color') ?: '#fefefe';
$title_color   = get_sub_field('title_color') ?: '#fff';
$section_title = get_sub_field('title') ?: __('Latest News', 'wp_bootstrap_starter');

$is_rtl = is_rtl();
$dir    = $is_rtl ? 'rtl' : 'ltr';

// Query 5 posts only
$args = [
    'post_type'           => 'post',
    'posts_per_page'      => 5,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
];

// Multilingual
if (defined('ICL_LANGUAGE_CODE')) {
    $args['suppress_filters'] = false;
    $args['lang']             = ICL_LANGUAGE_CODE;
} elseif (function_exists('pll_current_language')) {
    $args['lang'] = pll_current_language('slug');
}

$q = new WP_Query($args);

// Fallback لكل اللغات لو ما رجع شيء
if (!$q->have_posts()) {
    $fallback                     = $args;
    $fallback['suppress_filters'] = false;
    $fallback['lang']             = 'all';
    $q                            = new WP_Query($fallback);
}
?>

<section class="ls-news ls-news--grid js-scroll-up"
    dir="<?php echo esc_attr($dir); ?>"
    style="--ls-bg:<?php echo esc_attr($bg); ?>; --ls-title:<?php echo esc_attr($title_color); ?>;">

    <div class="container">

        <div class="ls-news__head">
            <h2 class="ls-news__title">
                <?php echo esc_html($section_title); ?>
            </h2>
        </div>

        <?php if ($q->have_posts()) : ?>

            <?php
            // نحول النتائج إلى مصفوفة ثم نفصل الكبير عن الصغار
            $posts      = $q->posts;
            $big_post   = array_pop($posts);  // آخر واحد = الكبير
            $small_posts = $posts;
            global $post;
            ?>

            <div class="ls-news__grid">

                <!-- LEFT: up to 4 small posts -->
                <div class="ls-news__left">
                    <?php if (!empty($small_posts)) : ?>
                        <?php foreach ($small_posts as $small) : ?>
                            <?php
                            $post = $small;
                            setup_postdata($post);

                            $small_title = get_the_title();
                            $small_link  = get_permalink();
                            $small_img   = get_the_post_thumbnail_url(get_the_ID(), 'medium_large')
                                ?: get_stylesheet_directory_uri() . '/assets/images/placeholder-16x9.jpg';

                            // مدة الفيديو (اختياري – ACF text field)
                            $small_duration = function_exists('get_field')
                                ? (string) get_field('video_duration')
                                : '';
                            ?>
                            <article class="ls-news__item ls-news__item--small">
                                <a class="ls-news__card ls-news__card--small"
                                    href="<?php echo esc_url($small_link); ?>">

                                    <div class="ls-news__img">
                                        <img src="<?php echo esc_url($small_img); ?>"
                                            alt="<?php echo esc_attr($small_title); ?>"
                                            loading="lazy"
                                            decoding="async">
                                        <span class="ls-news__overlay" aria-hidden="true"></span>

                                        <?php if (!empty($small_duration)) : ?>
                                            <span class="ls-news__duration">
                                                <?php echo esc_html($small_duration); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="ls-news__body">
                                        <span class="ls-news__meta">
                                            <?php echo esc_html(get_the_date()); ?>
                                        </span>
                                        <h3 class="ls-news__heading">
                                            <?php echo esc_html($small_title); ?>
                                        </h3>
                                    </div>
                                </a>
                            </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div><!-- /.ls-news__left -->


                <!-- RIGHT: big post (last one) -->
                <?php if ($big_post) : ?>
                    <?php
                    $post = $big_post;
                    setup_postdata($post);

                    $big_title = get_the_title();
                    $big_link  = get_permalink();
                    $big_img   = get_the_post_thumbnail_url(get_the_ID(), 'large')
                        ?: get_stylesheet_directory_uri() . '/assets/images/placeholder-16x9.jpg';

                    $big_excerpt = wp_trim_words(
                        wp_strip_all_tags(get_the_excerpt()),
                        26,
                        '…'
                    );

                    $big_duration = function_exists('get_field')
                        ? (string) get_field('video_duration')
                        : '';
                    ?>
                    <article class="ls-news__item ls-news__item--big">
                        <a class="ls-news__card ls-news__card--big"
                            href="<?php echo esc_url($big_link); ?>">

                            <div class="ls-news__img">
                                <img src="<?php echo esc_url($big_img); ?>"
                                    alt="<?php echo esc_attr($big_title); ?>"
                                    loading="lazy"
                                    decoding="async">
                                <span class="ls-news__overlay" aria-hidden="true"></span>

                                <?php if (!empty($big_duration)) : ?>
                                    <span class="ls-news__duration">
                                        <?php echo esc_html($big_duration); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="ls-news__body ls-news__body--big">
                                <span class="ls-news__meta">
                                    <?php echo esc_html(get_the_date()); ?>
                                </span>
                                <h3 class="ls-news__heading ls-news__heading--big">
                                    <?php echo esc_html($big_title); ?>
                                </h3>

                                <?php if (!empty($big_excerpt)) : ?>
                                    <p class="ls-news__excerpt">
                                        <?php echo esc_html($big_excerpt); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </article>
                <?php endif; ?>

            </div><!-- /.ls-news__grid -->

            <?php wp_reset_postdata(); ?>

        <?php else : ?>
            <div class="ls-news__empty">
                <?php esc_html_e('No posts available at the moment.', 'wp_bootstrap_starter'); ?>
            </div>
        <?php endif; ?>

    </div><!-- /.container -->
</section>