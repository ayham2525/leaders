<?php

/**
 * Flexible Layout: Image With Text Repeater
 * Field name: image_with_text_repeater
 * Sub fields:
 *  - visible (true/false)
 *  - content_repeater (repeater)
 *      - content (WYSIWYG)
 *      - image   (image ID or array)
 */

if (!defined('ABSPATH')) {
    exit;
}

$visible = get_sub_field('visible');

if (!$visible) {
    return; // allow hiding the whole block from backend
}

$rows = get_sub_field('content_repeater');

if (!$rows || !is_array($rows)) {
    return;
}
?>

<section class="ls-image-text">
    <div class="container">
        <?php foreach ($rows as $index => $row) :
            $content = isset($row['content']) ? $row['content'] : '';
            $image   = isset($row['image']) ? $row['image'] : null;

            if (!$content && !$image) {
                continue;
            }

            // even/odd index to alternate layout
            $is_reverse = ($index % 2 === 1);

            // --- handle image as ID or array ---
            $img_id  = null;
            $img_alt = '';

            if (is_array($image) && !empty($image['ID'])) {
                // Return format = Image Array
                $img_id  = (int) $image['ID'];
                $img_alt = !empty($image['alt'])
                    ? $image['alt']
                    : (!empty($image['title']) ? $image['title'] : get_the_title($img_id));
            } elseif (!empty($image)) {
                // Return format = Image ID
                $img_id  = (int) $image;
                $img_alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);

                if (!$img_alt) {
                    $img_alt = get_the_title($img_id);
                }
            }
        ?>
            <div class="js-scroll-up ls-image-text__item<?php echo $is_reverse ? ' ls-image-text__item--reverse' : ''; ?>">

                <div class="ls-image-text__media">
                    <?php if ($img_id) : ?>
                        <?php
                        echo wp_get_attachment_image(
                            $img_id,
                            'large',
                            false,
                            array(
                                'class'   => 'ls-image-text__img',
                                'alt'     => esc_attr($img_alt),
                                'loading' => 'lazy',
                            )
                        );
                        ?>
                    <?php endif; ?>
                </div>

                <div class="ls-image-text__content">
                    <?php if (!empty($content)) : ?>
                        <div class="ls-image-text__content-inner">
                            <?php echo wp_kses_post($content); ?>
                        </div>
                    <?php endif; ?>
                </div>

            </div><!-- /.ls-image-text__item -->
        <?php endforeach; ?>
    </div>
</section>