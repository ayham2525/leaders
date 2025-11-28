<?php
get_header();

while (have_posts()) : the_post();
    $banner = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

    <!-- ==================== BANNER (reuse academy banner styles) ==================== -->
    <section class="academy-banner" style="background-image:url('<?php echo esc_url($banner); ?>');">
        <div class="overlay"></div>
        <div class="container text-center">
            <h1 class="academy-title"><?php the_title(); ?></h1>
            <div class="divider mx-auto mt-3"></div>
        </div>
    </section>

    <!-- ==================== ACTIVITIES DETAILS (reuse academy layout) ==================== -->
    <section class="academy-details py-5">
        <div class="container">

            <?php if (have_rows('activities_info')): ?>
                <?php while (have_rows('activities_info')): the_row();

                    $branch_name  = get_sub_field('branch');
                    $location_url = get_sub_field('location');
                ?>
                    <div class="academy-branch mb-5 js-scroll-up">

                        <!-- Branch Title -->
                        <?php if ($branch_name): ?>
                            <h2 class="branch-title text-white mb-4">
                                <i class="fas fa-map-marker-alt text-red ml-2"></i>
                                <?php echo esc_html($branch_name); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if (have_rows('sports')): ?>
                            <?php
                            $sport_index = 0;
                            while (have_rows('sports')): the_row();
                                $sport_index++;

                                $sport_title = get_sub_field('sport_title');
                                $fees        = get_sub_field('fees');
                                $days        = get_sub_field('training_days');
                                $whatsapp    = get_sub_field('whatsapp');
                                $description = get_sub_field('text');

                                // WhatsApp URL (same logic as academy page)
                                $whatsapp_url = '';
                                if (!empty($whatsapp)) {
                                    $whatsapp_raw = trim($whatsapp);
                                    $wa_number    = preg_replace('/\D+/', '', $whatsapp_raw);

                                    if ($wa_number !== '') {
                                        // if starts with 0 (e.g. 050xxxxxxx) => 97150xxxxxxx
                                        if (strpos($wa_number, '0') === 0) {
                                            $wa_number = '971' . substr($wa_number, 1);
                                        }
                                        $whatsapp_url = 'https://wa.me/' . $wa_number;
                                    }
                                }

                                // Image (simple img tag, like academy cards)
                                $image         = get_sub_field('image');
                                $sport_img_url = '';
                                if (!empty($image['id'])) {
                                    $src = wp_get_attachment_image_src($image['id'], 'full');
                                    if (!empty($src[0])) {
                                        $sport_img_url = $src[0];
                                    }
                                }

                                // Normalize training days labels
                                $day_labels = [];
                                if (!empty($days) && is_array($days)) {
                                    foreach ($days as $d) {
                                        if (is_array($d)) {
                                            $day_labels[] = isset($d['label'])
                                                ? $d['label']
                                                : (isset($d['value']) ? $d['value'] : '');
                                        } else {
                                            $day_labels[] = $d;
                                        }
                                    }
                                    $day_labels = array_filter($day_labels);
                                }
                            ?>

                                <!-- Sport Card – same structure as academy page -->
                                <div class="sport-card js-scroll-up">
                                    <div class="sport-card-inner">

                                        <!-- LEFT SIDE: Info -->
                                        <div class="sport-info">

                                            <!-- Jersey + Number -->
                                            <div class="sport-jersey">
                                                <span class="sport-number">
                                                    <?php echo esc_html($sport_index); ?>
                                                </span>
                                            </div>

                                            <!-- Name -->
                                            <?php if ($sport_title): ?>
                                                <h3 class="sport-player-name">
                                                    <?php echo esc_html($sport_title); ?>
                                                </h3>
                                            <?php endif; ?>

                                            <!-- Meta rows -->
                                            <div class="sport-meta">

                                                <?php if ($fees): ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label"><?php _e('الرسوم:', 'main-theme'); ?></span>
                                                        <span class="meta-value"><?php echo esc_html($fees); ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (!empty($day_labels)): ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label"><?php _e('أيام التدريب:', 'main-theme'); ?></span>
                                                        <span class="meta-value">
                                                            <?php echo esc_html(implode('، ', $day_labels)); ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($branch_name): ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label"><?php _e('الفرع:', 'main-theme'); ?></span>
                                                        <span class="meta-value"><?php echo esc_html($branch_name); ?></span>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <!-- Description -->
                                            <?php if (!empty($description)): ?>
                                                <div class="sport-bio text-white-80">
                                                    <?php echo wp_kses_post($description); ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- Buttons (same layout: icons row + button below) -->
                                            <div class="sport-actions">

                                                <div class="sport-actions-icons">
                                                    <?php if ($location_url): ?>
                                                        <a href="<?php echo esc_url($location_url); ?>"
                                                            target="_blank"
                                                            class="btn-location">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($whatsapp_url): ?>
                                                        <a href="<?php echo esc_url($whatsapp_url); ?>"
                                                            target="_blank"
                                                            class="btn-whatsapp">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if ($sport_title): ?>
                                                    <button class="btn btn-book open-activity-register"
                                                        data-branch="<?php echo esc_attr($branch_name); ?>"
                                                        data-sport="<?php echo esc_attr($sport_title); ?>">
                                                        <?php _e('حجز تجربة الأداء', 'main-theme'); ?>
                                                    </button>
                                                <?php endif; ?>

                                            </div>

                                        </div>

                                        <!-- RIGHT SIDE: Image -->
                                        <?php if ($sport_img_url): ?>
                                            <div class="sport-photo">
                                                <img src="<?php echo esc_url($sport_img_url); ?>"
                                                    alt="<?php echo esc_attr($sport_title); ?>"
                                                    class="sport-img">
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            <?php endwhile; ?>
                        <?php endif; ?>

                    </div>

                <?php endwhile; ?>
            <?php endif; ?>

        </div>
    </section>

    <!-- ==================== MODAL ==================== -->
    <div id="activity-register-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3"><?php _e('حجز الفعالية الرياضية', 'main-theme'); ?></h3>

                <form id="activity-register-form">
                    <input type="hidden" name="action" value="submit_sports_registration">
                    <input type="hidden" name="activity_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="branch" id="activity_branch_name">
                    <input type="hidden" name="sport" id="activity_sport_name">

                    <input type="text" name="name" class="form-control mb-3" placeholder="<?php esc_attr_e('الاسم الكامل', 'main-theme'); ?>" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="<?php esc_attr_e('البريد الإلكتروني', 'main-theme'); ?>" required>
                    <input type="tel" name="phone" class="form-control mb-3" placeholder="<?php esc_attr_e('رقم الهاتف', 'main-theme'); ?>" required>
                    <input type="date" name="dob" class="form-control mb-4" required>

                    <button type="submit" class="btn btn-red w-100">
                        <?php _e('إرسال التسجيل', 'main-theme'); ?>
                    </button>
                </form>

            </div>
        </div>
    </div>

    <!-- ==================== JS / AJAX ==================== -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const modalEl = document.getElementById('activity-register-modal');
            const modal = modalEl && typeof bootstrap !== 'undefined' ?
                new bootstrap.Modal(modalEl) :
                null;

            // Open modal
            document.querySelectorAll(".open-activity-register").forEach(btn => {
                btn.addEventListener("click", () => {
                    const branchInput = document.getElementById("activity_branch_name");
                    const sportInput = document.getElementById("activity_sport_name");

                    if (branchInput) branchInput.value = btn.dataset.branch || '';
                    if (sportInput) sportInput.value = btn.dataset.sport || '';

                    if (modal) modal.show();
                });
            });

            // Submit AJAX
            const form = document.getElementById("activity-register-form");
            if (form) {
                form.addEventListener("submit", async (e) => {
                    e.preventDefault();

                    const data = new FormData(form);

                    const response = await fetch("<?php echo esc_url(admin_url('admin-ajax.php')); ?>", {
                        method: "POST",
                        body: data
                    });

                    let result = {};
                    try {
                        result = await response.json();
                    } catch (err) {
                        result = {
                            success: false,
                            message: "<?php echo esc_js(__('حدث خطأ، حاول مرة أخرى.', 'main-theme')); ?>"
                        };
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: result.success ? "success" : "error",
                            title: result.message || "",
                            confirmButtonText: "<?php echo esc_js(__('تم', 'main-theme')); ?>"
                        });
                    }

                    if (result.success) {
                        form.reset();
                        if (modal) modal.hide();
                    }
                });
            }

            // Scroll-up animation (reuse)
            const scrollElements = document.querySelectorAll('.js-scroll-up');

            if ('IntersectionObserver' in window && scrollElements.length) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            obs.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.15
                });

                scrollElements.forEach(el => observer.observe(el));
            } else {
                scrollElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>

<?php
endwhile;

get_footer();
?>