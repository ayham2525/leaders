<?php
get_header();

while (have_posts()) : the_post();
    $banner = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

    <div class="single-activity-banner">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="activity-title"><?php the_title(); ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="single-activity-details py-5">
        <div class="container">
            <div class="row">

                <?php if (have_rows('activities_info')) : ?>
                    <?php while (have_rows('activities_info')) : the_row();
                        $branch_index++;
                        $branch_name  = get_sub_field('branch');
                        $location_url = get_sub_field('location');
                    ?>

                        <h2 class="branch-title p-0 m-0">
                            <?php echo esc_html($branch_name); ?>
                        </h2>

                        <?php if (have_rows('sports')) : ?>
                            <?php $sport_index = 0; ?>

                            <?php while (have_rows('sports')) : the_row();
                                $sport_index++;

                                /* ================= BASIC DATA ================= */
                                $sport_title = get_sub_field('sport_title');
                                $fees        = get_sub_field('fees');
                                $days = [];
                                $is_rtl = is_rtl();

                                if (!empty($sport['training_days'])) {

                                    foreach ((array) $sport['training_days'] as $day) {

                                        // ACF safety
                                        if (is_array($day)) {
                                            $day = $day['label'] ?? $day['value'] ?? '';
                                        }

                                        $day = trim($day);
                                        if (!$day) continue;

                                        $key = normalize_day_key($day, $days_map);

                                        if ($key) {
                                            $days[] = $is_rtl
                                                ? $days_map[$key]['ar']
                                                : $days_map[$key]['en'];
                                        }
                                    }
                                }

                                $description = get_sub_field('text');
                                $link        = get_sub_field('link');
                                $faqs        = get_sub_field('faq');

                                /* ================= UNIQUE PREFIX (CRITICAL) ================= */
                                $prefix = 'branch-' . $branch_index . '-sport-' . $sport_index;
                                /* ================= TABS IDS (SAME AS WORKING PAGE) ================= */
                                $tabs_id           = $prefix . '-tabs';
                                $tabs_content_id   = $prefix . '-tabs-content';

                                $desc_tab_id       = $prefix . '-tab-desc';
                                $faq_tab_id        = $prefix . '-tab-faq';

                                $desc_pane_id      = $prefix . '-pane-desc';
                                $faq_pane_id       = $prefix . '-pane-faq';

                                $faq_accordion_id  = $prefix . '-faq-accordion';


                                /* ================= WHATSAPP ================= */
                                $whatsapp_raw  = trim(get_sub_field('whatsapp'));
                                $whatsapp_url  = '';
                                $wa_number_api = '';

                                if ($whatsapp_raw) {
                                    $digits = preg_replace('/\D+/', '', $whatsapp_raw);
                                    if (strpos($digits, '0') === 0) {
                                        $digits = '971' . substr($digits, 1);
                                    }
                                    $wa_number_api = $digits;
                                    $whatsapp_url  = 'https://wa.me/' . $digits;
                                }

                                /* ================= IMAGE ================= */
                                $image = get_sub_field('image');
                                $sport_img_url = ($image && isset($image['id']))
                                    ? wp_get_attachment_image_url($image['id'], 'full')
                                    : '';

                                /* ================= DAYS ================= */
                                $day_labels = [];
                                if (is_array($days)) {
                                    foreach ($days as $d) {
                                        $day_labels[] = is_array($d)
                                            ? ($d['label'] ?? $d['value'] ?? '')
                                            : $d;
                                    }
                                }
                            ?>

                                <div class="activity-card js-scroll-up pb-5">
                                    <div class="activity-info">

                                        <h3 class="activity-name py-3">
                                            <?php echo esc_html($sport_title); ?>
                                        </h3>

                                        <div class="row">

                                            <!-- ================= LEFT ================= -->
                                            <div class="col-md-6 col-sm-12">

                                                <?php if ($sport_img_url) : ?>
                                                    <img src="<?php echo esc_url($sport_img_url); ?>"
                                                        class="img-fluid"
                                                        alt="<?php echo esc_attr($sport_title); ?>">
                                                <?php endif; ?>

                                                <div class="sport-actions mt-4">
                                                    <div class="sport-actions-icons">

                                                        <?php if (!empty($location_url)) : ?>
                                                            <a href="<?php echo esc_url($location_url); ?>"
                                                                target="_blank"
                                                                class="btn-location">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($link) : ?>
                                                            <a href="<?php echo esc_url($link); ?>"
                                                                target="_blank"
                                                                class="btn-share"
                                                                data-copy="<?php echo esc_attr($link); ?>"
                                                                title="<?php esc_attr_e('Copy link', 'main-theme'); ?>">
                                                                <i class="fa fa-share"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($whatsapp_url) : ?>
                                                            <a href="<?php echo esc_url($whatsapp_url); ?>"
                                                                target="_blank"
                                                                class="btn-whatsapp">
                                                                <i class="fab fa-whatsapp"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <button type="button"
                                                            class="btn btn-book open-activity-register mt-3"
                                                            data-branch="<?php echo esc_attr($branch_name); ?>"
                                                            data-sport="<?php echo esc_attr($sport_title); ?>"
                                                            data-whatsapp="<?php echo esc_attr($wa_number_api); ?>">
                                                            <?php _e('Book Sports Activity', 'main-theme'); ?>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- ================= RIGHT ================= -->
                                            <div class="col-md-6 col-sm-12">

                                                <table class="program-meta-table">
                                                    <tr>
                                                        <td><strong><?php _e('Fees:', 'main-theme'); ?></strong></td>
                                                        <td><?php echo esc_html($fees); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong><?php _e('Days:', 'main-theme'); ?></strong></td>
                                                        <td><?php echo esc_html(implode(', ', $day_labels)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong><?php _e('Branch:', 'main-theme'); ?></strong></td>
                                                        <td><?php echo esc_html($branch_name); ?></td>
                                                    </tr>
                                                </table>

                                                <!-- ================= TABS ================= -->
                                                <div class="program-tabs mt-4">

                                                    <!-- Tabs Header -->
                                                    <ul class="nav nav-tabs"
                                                        id="<?php echo esc_attr($tabs_id); ?>"
                                                        role="tablist">

                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="nav-link active"
                                                                id="<?php echo esc_attr($desc_tab_id); ?>"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#<?php echo esc_attr($desc_pane_id); ?>"
                                                                type="button"
                                                                role="tab"
                                                                aria-controls="<?php echo esc_attr($desc_pane_id); ?>"
                                                                aria-selected="true">
                                                                <?php _e('Description', 'main-theme'); ?>
                                                            </button>
                                                        </li>

                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="nav-link"
                                                                id="<?php echo esc_attr($faq_tab_id); ?>"
                                                                data-bs-toggle="tab"
                                                                data-bs-target="#<?php echo esc_attr($faq_pane_id); ?>"
                                                                type="button"
                                                                role="tab"
                                                                aria-controls="<?php echo esc_attr($faq_pane_id); ?>"
                                                                aria-selected="false">
                                                                <?php _e('FAQs', 'main-theme'); ?>
                                                            </button>
                                                        </li>
                                                    </ul>

                                                    <!-- Tabs Content -->
                                                    <div class="tab-content p-3"
                                                        id="<?php echo esc_attr($tabs_content_id); ?>">

                                                        <!-- Description -->
                                                        <div
                                                            class="tab-pane fade show active"
                                                            id="<?php echo esc_attr($desc_pane_id); ?>"
                                                            role="tabpanel"
                                                            aria-labelledby="<?php echo esc_attr($desc_tab_id); ?>">

                                                            <div class="program-description">
                                                                <?php
                                                                $desc = (string) $description;

                                                                // Replace Facebook emoji images with alt text
                                                                $desc = preg_replace(
                                                                    '/<img[^>]+alt="([^"]+)"[^>]*>/u',
                                                                    '$1',
                                                                    $desc
                                                                );

                                                                // Normalize divs to line breaks
                                                                $desc = str_replace(
                                                                    ['<div dir="auto">', '<div>', '</div>'],
                                                                    ['', '', '<br>'],
                                                                    $desc
                                                                );

                                                                // Keep only safe formatting
                                                                $desc = strip_tags($desc, '<br><strong><b><em><i>');

                                                                echo wp_kses_post($desc);
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <!-- FAQ -->
                                                        <div
                                                            class="tab-pane fade"
                                                            id="<?php echo esc_attr($faq_pane_id); ?>"
                                                            role="tabpanel"
                                                            aria-labelledby="<?php echo esc_attr($faq_tab_id); ?>">

                                                            <?php if (!empty($faqs)) : ?>
                                                                <div class="accordion"
                                                                    id="<?php echo esc_attr($faq_accordion_id); ?>">

                                                                    <?php foreach ($faqs as $index => $faq) :
                                                                        $question   = $faq['title'] ?? '';
                                                                        $answer     = $faq['text'] ?? '';
                                                                        $is_first   = ($index === 0);

                                                                        $heading_id  = $faq_accordion_id . '-heading-' . $index;
                                                                        $collapse_id = $faq_accordion_id . '-collapse-' . $index;
                                                                    ?>
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header"
                                                                                id="<?php echo esc_attr($heading_id); ?>">

                                                                                <button
                                                                                    class="accordion-button<?php echo $is_first ? '' : ' collapsed'; ?> text-end"
                                                                                    type="button"
                                                                                    data-bs-toggle="collapse"
                                                                                    data-bs-target="#<?php echo esc_attr($collapse_id); ?>"
                                                                                    aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
                                                                                    aria-controls="<?php echo esc_attr($collapse_id); ?>">
                                                                                    <?php echo esc_html($question); ?>
                                                                                </button>
                                                                            </h2>

                                                                            <div
                                                                                id="<?php echo esc_attr($collapse_id); ?>"
                                                                                class="accordion-collapse collapse<?php echo $is_first ? ' show' : ''; ?>"
                                                                                aria-labelledby="<?php echo esc_attr($heading_id); ?>"
                                                                                data-bs-parent="#<?php echo esc_attr($faq_accordion_id); ?>">

                                                                                <div class="accordion-body">
                                                                                    <?php echo wpautop($answer); ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; ?>
                                                                </div>
                                                            <?php else : ?>
                                                                <p class="text-muted mb-0">
                                                                    <?php _e('No FAQs added yet.', 'main-theme'); ?>
                                                                </p>
                                                            <?php endif; ?>

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>

                        <?php endif; ?>

                    <?php endwhile; ?>
                <?php endif; ?>

            </div>
        </div>
    </section>


    <div id="activity-register-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3">
                    <?php _e('Book Sports Activity', 'main-theme'); ?>
                </h3>

                <form id="activity-register-form">
                    <input type="hidden" name="action" value="submit_sports_registration">
                    <input type="hidden" name="activity_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="branch" id="activity_branch_name">
                    <input type="hidden" name="sport" id="activity_sport_name">

                    <!-- WhatsApp (coach / activity) -->
                    <input type="hidden" name="activity_whatsapp" id="activity_whatsapp">

                    <input
                        type="text"
                        name="name"
                        class="form-control mb-3"
                        placeholder="<?php esc_attr_e('Full Name', 'main-theme'); ?>"
                        required>

                    <input
                        type="email"
                        name="email"
                        class="form-control mb-3"
                        placeholder="<?php esc_attr_e('Email Address', 'main-theme'); ?>"
                        required>

                    <!-- Phone with fixed 971 prefix -->
                    <div class="mb-3">
                        <label class="form-label d-block">
                            <?php _e('Phone Number', 'main-theme'); ?>
                        </label>

                        <div class="input-group">
                            <span class="input-group-text">+971</span>
                            <input
                                type="tel"
                                name="phone_suffix"
                                class="form-control"
                                placeholder="<?php esc_attr_e('Mobile number without leading zero', 'main-theme'); ?>"
                                inputmode="tel"
                                dir="ltr"
                                required>
                        </div>

                        <input type="hidden" name="phone" id="activity_full_phone">
                    </div>

                    <label>
                        <?php _e('Date of Birth', 'main-theme'); ?>
                    </label>

                    <input
                        type="date"
                        name="dob"
                        class="form-control mb-4"
                        required>

                    <button type="submit" class="btn btn-red w-100">
                        <?php _e('Submit Registration', 'main-theme'); ?>
                    </button>
                </form>

            </div>
        </div>
    </div>


    <!-- ==================== JS / AJAX ==================== -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const ajaxUrl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
            const genericError = "<?php echo esc_js(__('An error occurred, please try again.', 'main-theme')); ?>";
            const okLabel = "<?php echo esc_js(__('OK', 'main-theme')); ?>";
            const copySuccessMsg = "<?php echo esc_js(__('Link copied successfully.', 'main-theme')); ?>";
            const copyFailMsg = "<?php echo esc_js(__('Failed to copy the link, please try again.', 'main-theme')); ?>";
            const connErrorMsg = "<?php echo esc_js(__('Connection error, please try again.', 'main-theme')); ?>";

            const modalEl = document.getElementById('activity-register-modal');
            const modal = modalEl && typeof bootstrap !== 'undefined' ?
                new bootstrap.Modal(modalEl) :
                null;

            // Open modal
            document.querySelectorAll(".open-activity-register").forEach(btn => {
                btn.addEventListener("click", () => {
                    const branchInput = document.getElementById("activity_branch_name");
                    const sportInput = document.getElementById("activity_sport_name");
                    const waInput = document.getElementById("activity_whatsapp");

                    if (branchInput) branchInput.value = btn.dataset.branch || '';
                    if (sportInput) sportInput.value = btn.dataset.sport || '';
                    if (waInput) waInput.value = btn.dataset.whatsapp || '';

                    if (modal) modal.show();
                });
            });

            // Submit AJAX
            const form = document.getElementById("activity-register-form");
            if (form) {
                form.addEventListener("submit", async (e) => {
                    e.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"]');

                    const setLoading = (isLoading) => {
                        if (!submitBtn) return;

                        if (isLoading) {
                            submitBtn.disabled = true;
                            if (!submitBtn.dataset.originalHtml) {
                                submitBtn.dataset.originalHtml = submitBtn.innerHTML;
                            }
                            submitBtn.innerHTML =
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                                submitBtn.dataset.originalHtml;
                        } else {
                            submitBtn.disabled = false;
                            if (submitBtn.dataset.originalHtml) {
                                submitBtn.innerHTML = submitBtn.dataset.originalHtml;
                            }
                        }
                    };

                    setLoading(true);

                    // Build full phone: 971 + suffix digits
                    const suffixInput = form.querySelector('input[name="phone_suffix"]');
                    const fullPhone = form.querySelector('#activity_full_phone');

                    if (suffixInput && fullPhone) {
                        let suffix = suffixInput.value || '';
                        suffix = suffix.replace(/\D+/g, '');
                        suffix = suffix.replace(/^0+/, '');
                        fullPhone.value = suffix ? ('971' + suffix) : '';
                    }

                    const data = new FormData(form);

                    let response;
                    try {
                        response = await fetch(ajaxUrl, {
                            method: "POST",
                            body: data,
                            credentials: "same-origin"
                        });
                    } catch (err) {
                        setLoading(false);

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: "error",
                                title: connErrorMsg,
                                confirmButtonText: okLabel
                            });
                        } else {
                            alert(connErrorMsg);
                        }
                        return;
                    }

                    let result = {};
                    try {
                        result = await response.json();
                    } catch (err) {
                        result = {
                            success: false,
                            message: genericError
                        };
                    }

                    setLoading(false);

                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: result.success ? "success" : "error",
                            title: result.message || "",
                            confirmButtonText: okLabel
                        });
                    } else {
                        alert(result.message || (result.success ? okLabel : genericError));
                    }

                    if (result.success) {
                        form.reset();
                        if (modal) modal.hide();
                    }
                });
            }

            // Scroll-up animation
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

            // Copy to clipboard on share click
            document.querySelectorAll('.btn-share').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const textToCopy = this.getAttribute('data-copy') || '';
                    if (!textToCopy) return;

                    const showSuccess = () => {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: copySuccessMsg,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        } else {
                            alert(copySuccessMsg);
                        }
                    };

                    const showFail = () => {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
                                title: copyFailMsg,
                                showConfirmButton: true
                            });
                        } else {
                            alert(copyFailMsg);
                        }
                    };

                    // Modern API
                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(textToCopy)
                            .then(showSuccess)
                            .catch(showFail);
                    } else {
                        // Fallback
                        const temp = document.createElement('textarea');
                        temp.value = textToCopy;
                        temp.setAttribute('readonly', '');
                        temp.style.position = 'absolute';
                        temp.style.left = '-9999px';
                        document.body.appendChild(temp);
                        temp.select();
                        try {
                            document.execCommand('copy');
                            showSuccess();
                        } catch (err) {
                            showFail();
                        }
                        document.body.removeChild(temp);
                    }
                });
            });
        });
    </script>

<?php
endwhile;
get_footer();
?>