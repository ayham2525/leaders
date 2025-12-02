<?php


if (function_exists('get_sub_field') && get_sub_field('visible')) :

    $text       = trim((string) get_sub_field('text'));

?>

    <section class="single_text js-scroll-up">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="text">
                        <?php echo $text; ?>
                    </div>
                </div>
            </div>

        </div>
    </section>

<?php
endif;
?>