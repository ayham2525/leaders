<?php

/**
 * About Academy block – Updated to match new ACF structure
 *
 * New ACF fields:
 * visible (true/false)
 * background_color
 * title_color
 * text_color
 * title
 * text (WYSIWYG)
 * content_repeater (Repeater)
 *   - image
 *   - title
 *   - text
 */

$visible = get_sub_field('visible');
if (!$visible) return;

// Colors
$bg       = get_sub_field('background_color') ?: '#000000';
$titleCol = get_sub_field('title_color')      ?: '#D32F2F';
$textCol  = get_sub_field('text_color')       ?: '#FFFFFF';

// Main content
$title     = trim((string) get_sub_field('title')) ?: get_the_title();
$mainText  = get_sub_field('text') ?: '';
$repeater  = get_sub_field('content_repeater'); // array of rows
$link  = get_sub_field('link');

?>

<section class="about-academy js-scroll-up">
    <div class="container">

        <div class="row align-items-start">

            <!-- LEFT SIDE -->
            <div class="col-lg-5">

                <?php if ($title): ?>


                    <h2 class="about-academy__title">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if (!empty($mainText)): ?>
                    <div class="about-academy__text">
                        <?php echo wp_kses_post($mainText); ?>
                    </div>
                <?php endif; ?>

                <?php if ($link): ?>
                    <a href="<?php echo esc_url($link['url']); ?>" class="btn-red">
                        <?php echo esc_html($link['title']); ?>
                        <span class="arrow">→</span>
                    </a>
                <?php endif; ?>

            </div>

            <!-- RIGHT SIDE CARDS -->
            <div class="col-lg-7">

                <div class="about-academy__grid">

                    <?php foreach ($repeater as $row): ?>

                        <?php
                        // 1) Get image field from row
                        $imgId = 0;
                        if (!empty($row['image'])) {

                            if (is_array($row['image']) && isset($row['image']['ID'])) {
                                $imgId = $row['image']['ID'];     // ACF return: array
                            } elseif (is_numeric($row['image'])) {
                                $imgId = (int) $row['image'];     // ACF return: ID
                            }
                        }

                        // 2) Generate <img> HTML ONLY IF ID IS VALID
                        $imgHtml = $imgId ? wp_get_attachment_image(
                            $imgId,
                            'full',
                            false,
                            ['class' => 'about-academy__icon', 'loading' => 'lazy']
                        ) : '';
                        ?>

                        <div class="about-academy__card">

                            <?php if ($imgHtml): ?>
                                <div class="card-icon">
                                    <?php echo $imgHtml; ?>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($row['title'])): ?>
                                <h3 class="card-title">
                                    <?php echo esc_html($row['title']); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if (!empty($row['text'])): ?>
                                <div class="card-text">
                                    <?php echo wp_kses_post($row['text']); ?>
                                </div>
                            <?php endif; ?>

                        </div>

                    <?php endforeach; ?>


                </div>

            </div>

        </div>

    </div>
</section>