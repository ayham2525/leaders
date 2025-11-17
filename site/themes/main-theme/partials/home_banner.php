<?php

/**
 * Home Banner (ACF Flexible layout)
 */
if (!function_exists('get_sub_field')) return;

$visible = (bool) get_sub_field('visible');
if (!$visible) return;

$media_type  = trim((string) get_sub_field('media_type'));
$video_url   = trim((string) get_sub_field('video_url')); // e.g. /uploads/2025/10/banner.mp4
$text        = (string) get_sub_field('text');
$button_lbl  = (string) (get_sub_field('button_label') ?: (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'ar' ? 'تعرف علينا' : 'Learn more'));
$button_url  = trim((string) (get_sub_field('button_url') ?: $video_url));
$poster_id   = get_sub_field('poster');
$poster_src  = $poster_id ? wp_get_attachment_image_url($poster_id, 'full') : '';

$is_file_video = (bool) preg_match('~\.(mp4|webm|ogg)$~i', $video_url);
$dir_class     = (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'ar') ? 'is-rtl' : 'is-ltr';
?>
<section class="home-banner <?php echo esc_attr($dir_class); ?>" aria-label="<?php esc_attr_e('Home Banner', 'leaderssports'); ?>">
    <div class="home-banner__media" aria-hidden="true">
        <?php if ($media_type === 'Video' && $is_file_video && $video_url): ?>
            <video
                class="home-banner__video"
                autoplay
                controls
                muted
                playsinline
                loop
                preload="auto"
                <?php echo $poster_src ? 'poster="' . esc_url($poster_src) . '"' : ''; ?>>
                <source src="<?php echo esc_url($video_url); ?>" type="<?php echo esc_attr(wp_check_filetype($video_url)['type'] ?: 'video/mp4'); ?>">
                <?php
                // Optional secondary format if you uploaded a WebM alongside the MP4
                $maybe_webm = preg_replace('~\.mp4$~i', '.webm', $video_url);
                if ($maybe_webm && $maybe_webm !== $video_url): ?>
                    <source src="<?php echo esc_url($maybe_webm); ?>" type="video/webm">
                <?php endif; ?>
                <?php esc_html_e('Your browser does not support the video tag.', 'leaderssports'); ?>
            </video>
        <?php elseif ($poster_src): ?>
            <div class="home-banner__image" style="background-image:url('<?php echo esc_url($poster_src); ?>');"></div>
        <?php else: ?>
            <div class="home-banner__fallback"></div>
        <?php endif; ?>

        <span class="home-banner__overlay" aria-hidden="true"></span>
        <span class="home-banner__gradient" aria-hidden="true"></span>
    </div>

    <div class="home-banner__inner container">
        <div class="home-banner__content">
            <?php if ($text): ?>
                <h1 class="home-banner__title"><?php echo wp_kses_post($text); ?></h1>
            <?php endif; ?>

            <?php if ($button_url): ?>
                <a class="home-banner__btn" href="<?php echo esc_url($button_url); ?>" aria-label="<?php echo esc_attr($button_lbl); ?>">
                    <span class="home-banner__btn-icon" aria-hidden="true">
                        <svg viewBox="0 0 64 64" width="22" height="22" focusable="false" aria-hidden="true">
                            <circle cx="32" cy="32" r="31" stroke="currentColor" fill="none" stroke-width="2" />
                            <polygon points="26,20 48,32 26,44" fill="currentColor" />
                        </svg>
                    </span>
                    <span class="home-banner__btn-label"><?php echo esc_html($button_lbl); ?></span>
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>