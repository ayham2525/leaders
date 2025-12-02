<?php
get_header();

while (have_posts()) : the_post();
    $banner       = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $academy_info = get_field('academy_info'); // main repeater
?>

    <!-- ==================== البانر ==================== -->
    <section class="academy-banner" style="background-image:url('<?php echo esc_url($banner); ?>');">
        <div class="overlay"></div>
        <div class="container text-center">
            <h1 class="academy-title"><?php the_title(); ?></h1>
            <div class="divider mx-auto mt-3"></div>
        </div>
    </section>

    <!-- ==================== تفاصيل الأكاديمية ==================== -->
    <section class="academy-details py-5">
        <div class="container">

            <?php if (! empty($academy_info) && is_array($academy_info)) : ?>

                <?php foreach ($academy_info as $branch) :

                    $branch_name  = isset($branch['branch'])   ? $branch['branch']   : '';
                    $location_url = isset($branch['location']) ? $branch['location'] : '';
                    $sports       = isset($branch['sports'])   ? $branch['sports']   : [];

                ?>
                    <div class="academy-branch mb-5 js-scroll-up">

                        <!-- Branch Title -->
                        <?php if ($branch_name) : ?>
                            <h2 class="branch-title text-white mb-4">
                                <i class="fas fa-map-marker-alt text-red ml-2"></i>
                                <?php echo esc_html($branch_name); ?>
                            </h2>
                        <?php endif; ?>

                        <?php if (! empty($sports) && is_array($sports)) :

                            $sport_index = 0;

                            foreach ($sports as $sport) :
                                $sport_index++;

                                $sport_title = isset($sport['sport_title'])   ? $sport['sport_title']   : '';
                                $fees        = isset($sport['fees'])          ? $sport['fees']          : '';
                                $days        = isset($sport['training_days']) ? $sport['training_days'] : [];
                                $description = isset($sport['text'])          ? $sport['text']          : '';

                                // WhatsApp (raw from ACF)
                                $whatsapp_raw = isset($sport['whatsapp']) ? trim($sport['whatsapp']) : '';
                                $whatsapp_url = '';
                                $wa_number    = ''; // normalized WA number used for API

                                if ($whatsapp_raw !== '') {
                                    // remove any non-digits (spaces, +, -, etc.)
                                    $wa_number_digits = preg_replace('/\D+/', '', $whatsapp_raw);

                                    if ($wa_number_digits !== '') {
                                        // if number starts with 0 (e.g. 050xxxxxxx) convert to UAE intl format 97150xxxxxxx
                                        if (strpos($wa_number_digits, '0') === 0) {
                                            $wa_number_digits = '971' . substr($wa_number_digits, 1);
                                        }
                                        $wa_number    = $wa_number_digits;
                                        $whatsapp_url = 'https://wa.me/' . $wa_number_digits;
                                    }
                                }

                                $sport_img_id  = isset($sport['image']) ? $sport['image'] : '';
                                $sport_img_url = $sport_img_id ? wp_get_attachment_image_url($sport_img_id, 'full') : '';

                                // Normalize training days labels
                                $day_labels = [];
                                if (! empty($days) && is_array($days)) {
                                    foreach ($days as $d) {
                                        if (is_array($d)) {
                                            $day_labels[] = isset($d['label']) ? $d['label'] : (isset($d['value']) ? $d['value'] : '');
                                        } else {
                                            $day_labels[] = $d;
                                        }
                                    }
                                    $day_labels = array_filter($day_labels);
                                }
                        ?>

                                <!-- Sport Card (new design) -->
                                <div class="sport-card js-scroll-up">
                                    <div class="sport-card-inner">

                                        <!-- LEFT SIDE: Info -->
                                        <div class="sport-info">

                                            <!-- Jersey + Number -->
                                            <div class="sport-jersey"></div>

                                            <!-- Name -->
                                            <?php if ($sport_title) : ?>
                                                <h3 class="sport-player-name">
                                                    <?php echo esc_html($sport_title); ?>
                                                </h3>
                                            <?php endif; ?>

                                            <!-- Meta rows -->
                                            <div class="sport-meta">

                                                <?php if ($fees) : ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label">الرسوم:</span>
                                                        <span class="meta-value"><?php echo esc_html($fees); ?></span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if (! empty($day_labels)) : ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label">أيام التدريب:</span>
                                                        <span class="meta-value">
                                                            <?php echo esc_html(implode('، ', $day_labels)); ?>
                                                        </span>
                                                    </div>
                                                <?php endif; ?>

                                                <?php if ($branch_name) : ?>
                                                    <div class="meta-row">
                                                        <span class="meta-label">الفرع:</span>
                                                        <span class="meta-value"><?php echo esc_html($branch_name); ?></span>
                                                    </div>
                                                <?php endif; ?>

                                            </div>

                                            <!-- Description -->
                                            <?php if (! empty($description)) : ?>
                                                <div class="sport-bio text-white-80">
                                                    <?php echo wp_kses_post($description); ?>
                                                </div>
                                            <?php endif; ?>


                                            <!-- Buttons -->
                                            <div class="sport-actions">

                                                <div class="sport-actions-icons">
                                                    <?php if ($location_url) : ?>
                                                        <a href="<?php echo esc_url($location_url); ?>"
                                                            target="_blank"
                                                            class="btn-location" rel="noopener">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </a>
                                                    <?php endif; ?>

                                                    <?php if ($whatsapp_url) : ?>
                                                        <a href="<?php echo esc_url($whatsapp_url); ?>"
                                                            target="_blank"
                                                            class="btn-whatsapp" rel="noopener">
                                                            <i class="fab fa-whatsapp"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>

                                                <?php if ($sport_title) : ?>
                                                    <button
                                                        class="btn btn-book open-register"
                                                        type="button"
                                                        data-branch="<?php echo esc_attr($branch_name); ?>"
                                                        data-sport="<?php echo esc_attr($sport_title); ?>"
                                                        data-whatsapp="<?php echo esc_attr($wa_number); ?>">
                                                        <?php _e('حجز تجربة الأداء', 'main-theme'); ?>
                                                    </button>
                                                <?php endif; ?>

                                            </div>

                                        </div>

                                        <!-- RIGHT SIDE: Player image -->
                                        <?php if ($sport_img_url) : ?>
                                            <div class="sport-photo">
                                                <img src="<?php echo esc_url($sport_img_url); ?>"
                                                    alt="<?php echo esc_attr($sport_title); ?>"
                                                    class="sport-img">
                                            </div>
                                        <?php endif; ?>

                                    </div>
                                </div>

                            <?php endforeach; // end sports foreach 
                            ?>

                        <?php endif; // has sports 
                        ?>

                    </div>
                <?php endforeach; // end branches foreach 
                ?>

            <?php endif; // has academy_info 
            ?>

        </div>
    </section>


    <!-- ==================== MODAL ==================== -->
    <div id="academy-register-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3">تسجيل في الأكاديمية</h3>

                <form id="academy-register-form" novalidate>
                    <input type="hidden" name="action" value="submit_academy_registration">
                    <input type="hidden" name="academy_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <input type="hidden" name="branch" id="branch_name">
                    <input type="hidden" name="sport" id="sport_name">
                    <input type="hidden" name="academy_whatsapp" id="academy_whatsapp">
                    <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce('academy_register_nonce')); ?>">

                    <input type="text" name="name" class="form-control mb-3" placeholder="الاسم الكامل" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required>
                    <input type="tel" name="phone" class="form-control mb-3" placeholder="رقم الهاتف" required>
                    <label><?php _e('تاريخ الميلاد', 'main-theme'); ?></label>
                    <input type="date" name="dob" class="form-control mb-4" required placeholder="تاريخ الميلاد">

                    <button type="submit" class="btn btn-red w-100">إرسال التسجيل</button>
                </form>

            </div>
        </div>
    </div>


    <!-- ==================== JS ==================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            /* ---------- Modal & AJAX ---------- */
            const modalEl = document.getElementById('academy-register-modal');
            let modal = null;

            if (modalEl && typeof bootstrap !== 'undefined') {
                modal = new bootstrap.Modal(modalEl);
            }

            // Open modal
            document.querySelectorAll('.open-register').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    const branchInput = document.getElementById('branch_name');
                    const sportInput = document.getElementById('sport_name');
                    const whatsappInput = document.getElementById('academy_whatsapp');

                    if (branchInput) branchInput.value = this.dataset.branch || '';
                    if (sportInput) sportInput.value = this.dataset.sport || '';
                    if (whatsappInput) whatsappInput.value = this.dataset.whatsapp || '';

                    if (modal) {
                        modal.show();
                    }
                });
            });

            // Submit to backend
            const form = document.getElementById('academy-register-form');
            if (form) {
                form.addEventListener('submit', async function(e) {
                    e.preventDefault();

                    const data = new FormData(form);

                    let response;
                    try {
                        response = await fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                            method: 'POST',
                            body: data,
                            credentials: 'same-origin'
                        });
                    } catch (networkError) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: 'خطأ في الاتصال، حاول مرة أخرى.',
                                confirmButtonText: 'تم'
                            });
                        }
                        return;
                    }

                    let result = {};
                    try {
                        result = await response.json();
                    } catch (err) {
                        result = {
                            success: false,
                            message: 'حدث خطأ، حاول مرة أخرى.'
                        };
                    }

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: result.success ? 'success' : 'error',
                            title: result.message || '',
                            confirmButtonText: 'تم'
                        });
                    }

                    if (result.success) {
                        form.reset();
                        if (modal) modal.hide();
                    }
                });
            }

            /* ---------- Scroll-up animation ---------- */
            const scrollElements = document.querySelectorAll('.js-scroll-up');

            if ('IntersectionObserver' in window && scrollElements.length) {
                const observer = new IntersectionObserver((entries, obs) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            obs.unobserve(entry.target); // animate once
                        }
                    });
                }, {
                    threshold: 0.15
                });

                scrollElements.forEach(el => observer.observe(el));
            } else {
                // Fallback: show all
                scrollElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>

<?php
endwhile;
get_footer();
