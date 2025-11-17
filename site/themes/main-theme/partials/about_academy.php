<?php

/**
 * About Academy block (Flexible/Repeater row)
 * Uses get_sub_field() for all fields in the current row.
 *
 * Sub fields:
 * visible (true/false)
 * background_color (color)
 * title_color (color)
 * text_color (color)
 * image (image ID or array)
 * text (WYSIWYG)
 * title (text)
 * extra_text (WYSIWYG)
 * Optional: about_read_more_link (ACF Link)
 */

// Visibility
$visible = (bool) get_sub_field('visible');
if (!$visible) {
    return;
}

// Colors (fallbacks to brand palette)
$bg       = get_sub_field('background_color') ?: '#000000';
$titleCol = get_sub_field('title_color')      ?: '#D32F2F';
$textCol  = get_sub_field('text_color')       ?: '#FFFFFF';

// Content
$title     = trim((string) get_sub_field('title')) ?: get_the_title();
$mainText  = get_sub_field('text') ?: '';
$extra     = get_sub_field('extra_text') ?: '';
$link      = get_sub_field('about_read_more_link'); // may be null

// Image can be ID or array depending on ACF return format
$imgField  = get_sub_field('image');
$imgId     = 0;
if (is_array($imgField) && isset($imgField['ID'])) {
    $imgId = (int) $imgField['ID'];
} elseif (is_numeric($imgField)) {
    $imgId = (int) $imgField;
}

$imgHtml = $imgId ? wp_get_attachment_image(
    $imgId,
    'full',
    false,
    [
        'class'    => 'about-academy__img',
        'loading'  => 'lazy',
        'decoding' => 'async',
        'alt'      => esc_attr($title),
    ]
) : '';
?>

<section
    class="about-academy"
    style="background-color: <?php echo esc_attr($bg); ?>; --about-title: <?php echo esc_attr($titleCol); ?>; --about-text: <?php echo esc_attr($textCol); ?>;">
    <div class="container">
        <div class="about-academy__wrap">
            <div class="about-academy__media">
                <?php echo $imgHtml; ?>
                <span class="about-academy__red-swoosh" aria-hidden="true"></span>
            </div>

            <div class="about-academy__content">
                <?php if ($title !== ''): ?>
                    <h2 class="about-academy__title"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>

                <?php if (!empty($mainText)): ?>
                    <div class="about-academy__text">
                        <?php echo wp_kses_post($mainText); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($extra)): ?>
                    <div class="about-academy__extra">
                        <?php echo wp_kses_post($extra); ?>
                    </div>
                <?php endif; ?>


            </div>
        </div>
    </div>
</section>