<?php

/**
 * Animated Text With Repeater
 * ACF (Flexible/Repeater row) – uses get_sub_field()
 *
 * Fields:
 *  - visible (true/false)
 *  - background_color (color)
 *  - title_color (color)
 *  - text_color (color)
 *  - title (text)
 *  - text (WYSIWYG)
 *  - repeater_text (text)  -> e.g., "قيمنا:"
 *  - content_repeater (repeater)
 *      - text (text)
 */

if (!get_sub_field('visible')) return;

$bg        = get_sub_field('background_color') ?: '#212121';
$titleCol  = get_sub_field('title_color')      ?: '#D32F2F';
$textCol   = get_sub_field('text_color')       ?: '#FFFFFF';

$title     = trim((string) get_sub_field('title'));
$copy      = get_sub_field('text') ?: '';
$repLabel  = trim((string) get_sub_field('repeater_text')); // label above chips

$dir       = is_rtl() ? 'rtl' : 'ltr'; // WP aware
?>
<section class="animated-text"
    dir="<?php echo esc_attr($dir); ?>"
    style="--anim-bg: <?php echo esc_attr($bg); ?>; --anim-title: <?php echo esc_attr($titleCol); ?>; --anim-text: <?php echo esc_attr($textCol); ?>;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="animated-text__wrap" data-anim="section">
                    <div class="animated-text__content">
                        <?php if ($title !== ''): ?>
                            <h2 class="animated-text__title" data-anim="title"><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>

                        <?php if (!empty($copy)): ?>
                            <div class="animated-text__body" data-anim="body">
                                <?php echo wp_kses_post($copy); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($repLabel !== '' || have_rows('content_repeater')): ?>
                            <div class="animated-text__values" data-anim="values">
                                <?php if ($repLabel !== ''): ?>
                                    <span class="animated-text__label"><strong><?php echo esc_html($repLabel); ?></strong></span>
                                <?php endif; ?>

                                <?php if (have_rows('content_repeater')): ?>
                                    <span class="animated-text__chipstage"> <!-- fixed spot where one chip appears -->
                                        <?php while (have_rows('content_repeater')): the_row();
                                            $chip = trim((string) get_sub_field('text'));
                                            if ($chip === '') continue; ?>
                                            <span class="animated-text__chip"><?php echo esc_html($chip); ?></span>
                                        <?php endwhile; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>


                    </div>
                </div>
            </div>
        </div>

    </div>
</section>