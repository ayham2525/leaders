<?php

/**
 * Home Banner (ACF Flexible layout)
 */
if (!function_exists('get_sub_field')) return;

$visible = (bool) get_sub_field('visible');
if (!$visible) return;

// ======================
// Fields
// ======================
$media_type = strtolower(trim((string) get_sub_field('media_type')));

$image_id  = get_sub_field('image');
$image_src = $image_id ? wp_get_attachment_image_url($image_id, 'full') : '';

$video_url = trim((string) get_sub_field('video_url'));

$text = (string) get_sub_field('text');
$link = get_sub_field('link');

// RTL | LTR
$is_rtl = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'ar');
$dir_class = $is_rtl ? 'is-rtl' : 'is-ltr';
?>

<section class="home-banner <?php echo esc_attr($dir_class); ?>">
    <div class="home-banner__media">

        <?php if ($media_type === 'image' && $image_src): ?>
            <div class="home-banner__image" style="background-image:url('<?php echo esc_url($image_src); ?>');"></div>

        <?php elseif ($media_type === 'video' && $video_url): ?>
            <video
                class="home-banner__video"
                autoplay
                muted
                playsinline
                loop
                preload="auto"
                <?php echo $image_src ? 'poster="' . esc_url($image_src) . '"' : ''; ?>>
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo wp_check_filetype($video_url)['type'] ?: 'video/mp4'; ?>">
            </video>

        <?php else: ?>
            <div class="home-banner__fallback"></div>
        <?php endif; ?>

        <span class="home-banner__overlay"></span>
        <span class="home-banner__gradient"></span>
    </div>

    <div class="home-banner__inner container">
        <div class="home-banner__content">

            <?php if ($text): ?>
                <h1 class="home-banner__title">
                    <?php echo wp_kses_post($text); ?>
                </h1>
            <?php endif; ?>

            <?php if ($link): ?>

                <a class="home-banner__btn" href="<?php echo esc_url($link["url"]); ?>">
                    <span class="home-banner__btn-label">
                        <?php echo $link["title"]; ?>
                    </span>
                </a>
            <?php endif; ?>

        </div>
    </div>
</section>