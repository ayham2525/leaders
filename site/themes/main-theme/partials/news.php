<?php

/**
 * ACF Flex Block: News
 * Sub Fields: visible (true/false), background_color (color), title_color (color), title (text)
 */

if (!function_exists('ls_bool')) {
    function ls_bool($v)
    {
        return ($v === true || $v === '1' || $v === 1 || $v === 'true');
    }
}

// Visibility
$visible = get_sub_field('visible');
if (!ls_bool($visible)) return;

// Colors and title
$bg            = get_sub_field('background_color') ?: '#111';
$title_color   = get_sub_field('title_color') ?: '#fff';
$section_title = get_sub_field('title') ?: __('Latest News', 'wp_bootstrap_starter');

// Direction
$is_rtl = is_rtl();
$dir    = $is_rtl ? 'rtl' : 'ltr';

// Query posts
$args = [
    'post_type'           => 'post',
    'posts_per_page'      => 12,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
];

// Multilingual handling
if (defined('ICL_LANGUAGE_CODE')) {
    $args['suppress_filters'] = false;
    $args['lang'] = ICL_LANGUAGE_CODE;
} elseif (function_exists('pll_current_language')) {
    $args['lang'] = pll_current_language('slug');
}

$q = new WP_Query($args);

if (!$q->have_posts()) {
    $fallback = $args;
    $fallback['suppress_filters'] = false;
    $fallback['lang'] = 'all';
    $q = new WP_Query($fallback);
}

$uid      = 'news-' . uniqid();
$sliderId = $uid . '-slider';
?>

<section id="<?php echo esc_attr($uid); ?>"
    class="ls-news"
    dir="<?php echo esc_attr($dir); ?>"
    style="--ls-bg:<?php echo esc_attr($bg); ?>; --ls-title:<?php echo esc_attr($title_color); ?>;">
    <div class="container">
        <div class="ls-news__head">
            <h2 class="ls-news__title"><?php echo esc_html($section_title); ?></h2>

            <div class="ls-news__nav" aria-controls="<?php echo esc_attr($sliderId); ?>">
                <button type="button" class="ls-news__next" aria-label="<?php esc_attr_e('Next', 'wp_bootstrap_starter'); ?>">&#8250;</button>
                <button type="button" class="ls-news__prev" aria-label="<?php esc_attr_e('Previous', 'wp_bootstrap_starter'); ?>">&#8249;</button>
            </div>
        </div>

        <div id="<?php echo esc_attr($sliderId); ?>"
            class="ls-news__slider owl-carousel"
            data-rtl="<?php echo $is_rtl ? '1' : '0'; ?>"
            aria-roledescription="carousel"
            aria-live="polite"
            aria-label="<?php echo esc_attr($section_title); ?>">

            <?php if ($q->have_posts()): ?>
                <?php while ($q->have_posts()): $q->the_post();
                    $title = get_the_title();
                    $link  = get_permalink();
                    $img   = get_the_post_thumbnail_url(get_the_ID(), 'large') ?: get_stylesheet_directory_uri() . '/assets/images/placeholder-16x9.jpg';
                ?>
                    <article class="ls-news__item">
                        <a class="ls-news__card" href="<?php echo esc_url($link); ?>">
                            <div class="ls-news__img">
                                <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy" decoding="async">
                                <span class="ls-news__overlay" aria-hidden="true"></span>
                            </div>
                            <span class="ls-news__caption">
                                <span class="ls-news__caption-in"><?php echo esc_html($title); ?></span>
                            </span>
                        </a>
                    </article>
                <?php endwhile;
                wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="ls-news__empty"><?php esc_html_e('No posts available at the moment.', 'wp_bootstrap_starter'); ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>