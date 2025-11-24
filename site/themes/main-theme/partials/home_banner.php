<?php

if (!function_exists('get_sub_field')) return;

$visible = (bool) get_sub_field('visible');
if (!$visible) return;

$media_type = strtolower(trim((string) get_sub_field('media_type')));
$video_url  = trim((string) get_sub_field('video_url'));

$text  = get_sub_field('text');
$link  = get_sub_field('link');

$content_repeater = get_sub_field('content_repeater');

$is_rtl = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'ar');
$dir_class = $is_rtl ? 'is-rtl' : 'is-ltr';
?>

<section class="home-banner <?php echo esc_attr($dir_class); ?>">

    <div class="home-banner__media">

        <?php if ($media_type === 'video' && $video_url): ?>
            <video class="home-banner__video" autoplay muted playsinline loop preload="auto">
                <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
            </video>
        <?php endif; ?>

        <span class="home-banner__overlay"></span>
        <span class="home-banner__gradient"></span>
    </div>

    <div class="home-banner__inner">

        <?php if ($media_type === 'image' && !empty($content_repeater)): ?>

            <div class="swiper homeBannerSlider">
                <div class="swiper-wrapper">

                    <?php foreach ($content_repeater as $slide): ?>

                        <?php
                        $img_array = $slide['image'] ?? null;
                        $img_url   = $img_array['url'] ?? '';

                        $slide_title = $slide['title'] ?? '';

                        $slide_link = $slide['link'] ?? [];
                        ?>

                        <div class="swiper-slide">

                            <?php if ($img_url): ?>
                                <div class="home-banner__image"
                                    style="background-image:url('<?php echo esc_url($img_url); ?>');">
                                </div>
                            <?php endif; ?>

                            <div class="home-banner__content">
                                <?php if ($slide_title): ?>
                                    <h1 class="home-banner__title"><?php echo wp_kses_post($slide_title); ?></h1>
                                <?php endif; ?>

                                <?php if (!empty($slide_link['url'])): ?>
                                    <a class="home-banner__btn"
                                        href="<?php echo esc_url($slide_link['url']); ?>"
                                        target="<?php echo esc_attr($slide_link['target'] ?? '_self'); ?>">
                                        <?php echo esc_html($slide_link['title']); ?>
                                    </a>
                                <?php endif; ?>
                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

                <div class="swiper-pagination"></div>
            </div>

        <?php else: ?>

            <div class="home-banner__content">

                <?php if ($text): ?>
                    <h1 class="home-banner__title"><?php echo wp_kses_post($text); ?></h1>
                <?php endif; ?>

                <?php if (!empty($link['url'])): ?>
                    <a class="home-banner__btn"
                        href="<?php echo esc_url($link['url']); ?>"
                        target="<?php echo esc_attr($link['target'] ?? '_self'); ?>">
                        <?php echo esc_html($link['title']); ?>
                    </a>
                <?php endif; ?>

            </div>

        <?php endif; ?>

    </div>

</section>