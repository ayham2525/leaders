<?php

/**
 * Single Post Template — Leaders Sports
 */

get_header();

while (have_posts()) : the_post();

    $featured     = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $title        = get_the_title();
    $date         = get_the_date();
    $share_url    = urlencode(get_permalink());
    $share_title  = urlencode($title);
?>

    <section class="ls-single">

        <!-- ======== Hero Image ======== -->
        <?php if ($featured) : ?>
            <div class="ls-single__hero">
                <img
                    src="<?php echo esc_url($featured); ?>"
                    alt="<?php echo esc_attr($title); ?>"
                    class="img-fluid w-100"
                    loading="lazy">
            </div>
        <?php endif; ?>

        <!-- ======== Title ======== -->
        <div class="container">
            <h1 class="ls-single__title"><?php echo esc_html($title); ?></h1>

            <div class="ls-single__meta">
                <span class="ls-single__date">
                    <i class="las la-calendar"></i>
                    <?php echo esc_html($date); ?>
                </span>
            </div>
        </div>

        <!-- ======== Main Layout ======== -->
        <div class="container ls-single__body">
            <div class="row">

                <!-- ======== Content ======== -->
                <div class="col-md-8 col-sm-12">
                    <article class="ls-single__content">

                        <?php the_content(); ?>

                        <!-- Share icons -->
                        <div class="ls-single__share">
                            <h5><?php esc_html_e('Share this article', 'main-theme'); ?></h5>

                            <div class="ls-single__icons">
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_url($share_url); ?>"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on Facebook', 'main-theme'); ?>">
                                    <i class="lab la-facebook-f"></i>
                                </a>

                                <a href="https://twitter.com/intent/tweet?url=<?php echo esc_url($share_url); ?>&text=<?php echo esc_attr($share_title); ?>"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on Twitter', 'main-theme'); ?>">
                                    <i class="lab la-twitter"></i>
                                </a>

                                <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo esc_url($share_url); ?>"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on LinkedIn', 'main-theme'); ?>">
                                    <i class="lab la-linkedin-in"></i>
                                </a>

                                <a href="https://wa.me/?text=<?php echo urlencode($title . ' ' . get_permalink()); ?>"
                                    target="_blank" rel="noopener"
                                    aria-label="<?php esc_attr_e('Share on WhatsApp', 'main-theme'); ?>">
                                    <i class="lab la-whatsapp"></i>
                                </a>
                            </div>
                        </div>

                    </article>
                </div>

                <!-- ======== Related Posts ======== -->
                <div class="col-md-4 col-sm-12">
                    <aside class="ls-single__related">

                        <h3><?php esc_html_e('Related News', 'main-theme'); ?></h3>

                        <div class="ls-single__related-list">
                            <?php
                            $related = new WP_Query([
                                'post_type'      => 'post',
                                'posts_per_page' => 3,
                                'post__not_in'   => [get_the_ID()],
                                'no_found_rows'  => true,
                            ]);

                            if ($related->have_posts()) :
                                while ($related->have_posts()) :
                                    $related->the_post();
                            ?>
                                    <div class="ls-single__related-item">
                                        <a href="<?php the_permalink(); ?>" class="ls-single__related-link">

                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="ls-single__related-thumb">
                                                    <?php the_post_thumbnail('medium', ['loading' => 'lazy']); ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="ls-single__related-text">
                                                <h4><?php the_title(); ?></h4>
                                                <span class="ls-single__related-date">
                                                    <?php echo esc_html(get_the_date()); ?>
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                <?php
                                endwhile;
                                wp_reset_postdata();
                            else :
                                ?>
                                <p><?php esc_html_e('No related posts available.', 'main-theme'); ?></p>
                            <?php endif; ?>
                        </div>

                    </aside>
                </div>

            </div>
        </div>
    </section>

<?php endwhile; ?>

<?php get_footer(); ?>