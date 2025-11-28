<?php

/**
 * Animated Text Slider (Testimonials Style)
 * ACF Flexible Layout
 */

if (!get_sub_field('visible')) return;

$bg        = get_sub_field('background_color') ?: '#FFFFFF';
$titleCol  = get_sub_field('title_color')      ?: '#D32F2F';
$textCol   = get_sub_field('text_color')       ?: '#212121';

$title     = trim((string) get_sub_field('title')) ?: '';
$subtitle  = trim((string) get_sub_field('repeater_text')) ?: '';
$dir       = is_rtl() ? 'rtl' : 'ltr';
?>

<section class="animated-text testimonials js-scroll-up" dir="<?php echo esc_attr($dir); ?>"
    style="--anim-bg: <?php echo esc_attr($bg); ?>; --anim-title: <?php echo esc_attr($titleCol); ?>; --anim-text: <?php echo esc_attr($textCol); ?>;">

    <div class="container">

        <!-- TOP SECTION -->
        <div class="testimonials__header">
            <?php if ($subtitle): ?>
                <span class="testimonials__subtitle"><?php echo esc_html($subtitle); ?></span>
            <?php endif; ?>

            <?php if ($title): ?>
                <h2 class="testimonials__title"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
        </div>

        <!-- SLIDER -->
        <div class="swiper testimonials-slider">
            <div class="swiper-wrapper">

                <?php if (have_rows('content_repeater')): ?>
                    <?php while (have_rows('content_repeater')): the_row(); ?>

                        <?php
                        $slideText  = get_sub_field('text') ?: '';
                        $slideTitle = get_sub_field('title') ?: '';
                        $slideSubtitle = get_sub_field('subtitle') ?: '';

                        // FIXED IMAGE LOADING (ID or ARRAY)
                        $slideImg = get_sub_field('image');
                        $imgHtml = '';

                        if ($slideImg) {

                            // If image is ID → load directly
                            if (is_numeric($slideImg)) {
                                $imgHtml = wp_get_attachment_image(
                                    intval($slideImg),
                                    'thumbnail',
                                    false,
                                    [
                                        'class' => 'testimonials__avatar',
                                        'loading' => 'lazy',
                                        'decoding' => 'async'
                                    ]
                                );
                            }

                            // If image is array → extract ID
                            elseif (is_array($slideImg) && isset($slideImg['ID'])) {
                                $imgHtml = wp_get_attachment_image(
                                    intval($slideImg['ID']),
                                    'thumbnail',
                                    false,
                                    [
                                        'class' => 'testimonials__avatar',
                                        'loading' => 'lazy',
                                        'decoding' => 'async'
                                    ]
                                );
                            }
                        }
                        ?>

                        <div class="swiper-slide testimonials__slide">

                            <div class="testimonials__quote-icon">
                                <svg width="55" height="55" viewBox="0 0 24 24">
                                    <path fill="#d32f2f"
                                        d="M9 7H5a3 3 0 0 0-3 3v4a3 3 0 0 0 3 3h1v-4H5v-2h4V7Zm13 0h-4a3 3 0 0 0-3 3v4a3 3 0 0 0 3 3h1v-4h-1v-2h4V7Z" />
                                </svg>
                            </div>
                            <div class="testimonials__profile">
                                <?php echo $imgHtml; ?>
                                <div class="testimonials__profile-info">
                                    <?php if ($slideTitle): ?>
                                        <h4><?php echo esc_html($slideTitle); ?></h4>
                                    <?php endif; ?>

                                    <?php if ($slideSubtitle): ?>
                                        <span><?php echo esc_html($slideSubtitle); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="testimonials__text">
                                <?php echo wp_kses_post($slideText); ?>
                            </div>



                        </div>

                    <?php endwhile; ?>
                <?php endif; ?>

            </div>

            <!-- Pagination dots -->
            <div class="swiper-pagination testimonials-pagination"></div>

        </div>

    </div>
</section>