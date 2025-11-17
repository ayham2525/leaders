<?php

// ACF Fields
$visible = get_sub_field('visible');
if (!$visible) return; // Hide if not visible

$image  = get_sub_field('image');
$text   = get_sub_field('text');

// Image URL with focal point support
$img_url = '';
$img_left = 50;
$img_top  = 50;

if (!empty($image['id'])) {
    $src = wp_get_attachment_image_src($image['id'], 'full');
    if (!empty($src[0])) $img_url = $src[0];
}

if (isset($image['left'])) $img_left = $image['left'];
if (isset($image['top']))  $img_top  = $image['top'];
?>

<section class="ls-page-banner">
    <div class="banner-wrapper"
        style="
            background-image:url('<?php echo esc_url($img_url); ?>');
            background-position: <?php echo esc_attr($img_left); ?>% <?php echo esc_attr($img_top); ?>%;
            background-size: cover;
            background-repeat: no-repeat;">
        <div class="banner-overlay"></div>

        <div class="container text-center">
            <h1 class="banner-title">
                <?php echo esc_html($text); ?>
            </h1>


        </div>
    </div>
</section>