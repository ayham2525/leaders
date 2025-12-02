<?php
// ACF Fields
$visible = get_sub_field('visible');
if (!$visible) return; // Hide section if toggle is off

$title = get_sub_field('title');
$form  = get_sub_field('form_code');
?>

<section class="show_contact_form js-scroll-up">
    <div class="container">
        <div class="row align-items-start">

            <!-- LEFT COLUMN -->
            <div class="col-sm-12 col-md-6 mb-4 mb-md-0">
                <?php if ($title): ?>
                    <div class="contact-title mb-3">
                        <?php echo wp_kses_post($title); ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT COLUMN -->
            <div class="col-sm-12 col-md-6">
                <?php if ($form): ?>
                    <div class="contact-form">
                        <?php echo do_shortcode($form); ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>