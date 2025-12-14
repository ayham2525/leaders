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
                                $sport_title = get_sub_field('sport_title');
                                $fees        = get_sub_field('fees');
                                $days        = get_sub_field('training_days');
                                $description = get_sub_field('text');
                                $link        = get_sub_field('link');
                                $faqs        = get_sub_field('faq');
                            ?>

                                <div class="activity-card js-scroll-up pb-5">
                                    <div class="activity-info">

                                        <h3 class="activity-name py-3">
                                            <?php echo esc_html($sport_title); ?>
                                        </h3>

                                        <div class="row">
                                            <!-- Image & Actions -->
                                            <div class="col-md-6 col-sm-12">
                                                <?php
                                                $image = get_sub_field('image');

                                                if (!empty($image) && isset($image['id'])) :
                                                    $img_url = wp_get_attachment_image_url($image['id'], 'large');
                                                    $x = $image['left'] ?? 50;
                                                    $y = $image['top'] ?? 50;
                                                ?>
                                                    <img
                                                        src="<?php echo esc_url($img_url); ?>"
                                                        alt="<?php echo esc_attr($sport_title); ?>"
                                                        class="img-fluid"
                                                        style="object-position: <?php echo esc_attr($x); ?>% <?php echo esc_attr($y); ?>%;">
                                                <?php endif; ?>



                                                <div class="sport-actions mt-4">
                                                    <div class="sport-actions-icons">

                                                        <?php if ($location_url) : ?>
                                                            <a href="<?php echo esc_url($location_url); ?>"
                                                                target="_blank"
                                                                class="btn-location"
                                                                rel="noopener">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($link) : ?>
                                                            <a href="<?php echo esc_url($link); ?>"
                                                                target="_blank"
                                                                class="btn-share"
                                                                data-copy="<?php echo esc_attr($link); ?>"
                                                                title="<?php esc_attr_e('Copy location link', 'main-theme'); ?>">
                                                                <i class="fa fa-share"></i>
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if ($sport_title) : ?>
                                                            <button class="btn btn-book open-activity-register mt-3"
                                                                type="button"
                                                                data-branch="<?php echo esc_attr($branch_name); ?>"
                                                                data-sport="<?php echo esc_attr($sport_title); ?>">
                                                                <?php _e('Book Sports Activity', 'main-theme'); ?>
                                                            </button>
                                                        <?php endif; ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Meta & Tabs -->
                                            <div class="col-md-6 col-sm-12">

                                                <table class="program-meta-table">
                                                    <tr>
                                                        <td class="td-title">
                                                            <span class="meta-label"><?php _e('Fees:', 'main-theme'); ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="meta-value"><?php echo esc_html($fees); ?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-title">
                                                            <span class="meta-label"><?php _e('Days:', 'main-theme'); ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="meta-value">
                                                                <?php echo esc_html(implode(', ', (array) $days)); ?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="td-title">
                                                            <span class="meta-label"><?php _e('Branch:', 'main-theme'); ?></span>
                                                        </td>
                                                        <td>
                                                            <span class="meta-value"><?php echo esc_html($branch_name); ?></span>
                                                        </td>
                                                    </tr>
                                                </table>

                                                <div class="program-tabs mt-4">
                                                    <ul class="nav nav-tabs" role="tablist">
                                                        <li class="nav-item">
                                                            <button class="nav-link active" data-bs-toggle="tab">
                                                                <?php _e('Description', 'main-theme'); ?>
                                                            </button>
                                                        </li>
                                                        <li class="nav-item">
                                                            <button class="nav-link" data-bs-toggle="tab">
                                                                <?php _e('FAQs', 'main-theme'); ?>
                                                            </button>
                                                        </li>
                                                    </ul>

                                                    <div class="tab-content p-3">
                                                        <div class="tab-pane fade show active">
                                                            <?php echo wp_kses_post($description); ?>
                                                        </div>

                                                        <div class="tab-pane fade">
                                                            <?php if (!empty($faqs)) : ?>
                                                                <?php foreach ($faqs as $faq) : ?>
                                                                    <p><strong><?php echo esc_html($faq['title']); ?></strong></p>
                                                                    <p><?php echo wp_kses_post($faq['text']); ?></p>
                                                                <?php endforeach; ?>
                                                            <?php else : ?>
                                                                <p class="text-muted">
                                                                    <?php _e('No FAQs available yet.', 'main-theme'); ?>
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

                        <?php else : ?>
                            <p class="text-muted">
                                <?php _e('No sports added for this activity yet.', 'main-theme'); ?>
                            </p>
                        <?php endif; ?>

                    <?php endwhile; ?>

                <?php else : ?>
                    <p class="text-muted text-center">
                        <?php _e('No activity information available.', 'main-theme'); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ==================== MODAL ==================== -->
    <div id="activity-register-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3">
                    <?php _e('Book Sports Activity', 'main-theme'); ?>
                </h3>

                <form id="activity-register-form">
                    <input type="hidden" name="action" value="submit_sports_registration">

                    <input type="text" name="name" class="form-control mb-3"
                        placeholder="<?php esc_attr_e('Full Name', 'main-theme'); ?>" required>

                    <input type="email" name="email" class="form-control mb-3"
                        placeholder="<?php esc_attr_e('Email Address', 'main-theme'); ?>" required>

                    <label><?php _e('Phone Number', 'main-theme'); ?></label>
                    <div class="input-group mb-3">
                        <span class="input-group-text">+971</span>
                        <input type="tel" name="phone_suffix" class="form-control"
                            placeholder="<?php esc_attr_e('Mobile number without leading zero', 'main-theme'); ?>"
                            required>
                    </div>

                    <label><?php _e('Date of Birth', 'main-theme'); ?></label>
                    <input type="date" name="dob" class="form-control mb-4" required>

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