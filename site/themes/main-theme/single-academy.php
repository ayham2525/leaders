<?php
get_header();

while (have_posts()) : the_post();
    $banner       = get_the_post_thumbnail_url(get_the_ID(), 'full');
    $academy_info = get_field('academy_info'); // main repeater

    // Detect if we are on a specific branch page via ?branch=INDEX
    $selected_branch_index = isset($_GET['branch']) ? intval($_GET['branch']) : null;
    $has_branches          = !empty($academy_info) && is_array($academy_info);
?>

    <!-- ==================== البانر ==================== -->
    <section class="academy-banner" style="background-image:url('<?php echo esc_url($banner); ?>');">
        <div class="overlay"></div>
        <div class="container text-center">
            <h1 class="academy-title"><?php the_title(); ?></h1>
            <div class="divider mx-auto mt-3"></div>
        </div>
    </section>

    <!-- ==================== تفاصيل الأكاديمية / الفروع ==================== -->
    <section class="academy-details py-5">
        <div class="container">

            <?php if ($has_branches) : ?>

                <?php
                // ============= MODE 1: ACADEMY VIEW (LIST BRANCHES ONLY) =============
                if ($selected_branch_index === null || !isset($academy_info[$selected_branch_index])) :
                ?>

                    <div class="row g-4 justify-content-center">
                        <?php foreach ($academy_info as $index => $branch) :

                            $branch_name  = isset($branch['branch'])   ? $branch['branch']   : '';
                            $location_url = isset($branch['location']) ? $branch['location'] : '';

                            // Link to branch details on same academy page ?branch=index
                            $branch_link = add_query_arg('branch', $index, get_permalink());
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="academy-branch-card js-scroll-up">

                                    <div class="academy-branch-card__icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>

                                    <h2 class="branch-title mb-2">
                                        <?php echo esc_html($branch_name ?: __('فرع الأكاديمية', 'main-theme')); ?>
                                    </h2>

                                    <?php if ($location_url) : ?>
                                        <a href="<?php echo esc_url($location_url); ?>"
                                            target="_blank"
                                            rel="noopener"
                                            class="branch-location-link mb-3">
                                            <i class="fas fa-location-arrow"></i>
                                            <?php _e('عرض الموقع على الخريطة', 'main-theme'); ?>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo esc_url($branch_link); ?>"
                                        class="btn btn-red w-100 mt-auto">
                                        <?php _e('عرض الرياضات والتسجيل', 'main-theme'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                <?php
                // ============= MODE 2: BRANCH VIEW (SHOW SPORTS + REGISTER) =============
                else :
                    $branch       = $academy_info[$selected_branch_index];
                    $branch_name  = isset($branch['branch'])   ? $branch['branch']   : '';
                    $location_url = isset($branch['location']) ? $branch['location'] : '';
                    $sports       = isset($branch['sports'])   ? $branch['sports']   : [];
                ?>

                    <div class="academy-branch mb-5 js-scroll-up">

                        <div class="academy-branch__head d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
                            <h2 class="branch-title mb-0">
                                <i class="fas fa-map-marker-alt text-red ms-2"></i>
                                <?php echo esc_html($branch_name ?: __('فرع الأكاديمية', 'main-theme')); ?>
                            </h2>

                            <div class="d-flex align-items-center gap-2">
                                <a href="<?php echo esc_url(remove_query_arg('branch')); ?>"
                                    class="btn btn-outline-light btn-sm">
                                    <?php _e('العودة إلى جميع الفروع', 'main-theme'); ?>
                                </a>

                                <?php if ($location_url) : ?>
                                    <a href="<?php echo esc_url($location_url); ?>"
                                        target="_blank"
                                        rel="noopener"
                                        class="btn btn-light btn-sm">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php _e('عرض الموقع', 'main-theme'); ?>
                                    </a>
                                <?php endif; ?>

                            </div>
                        </div>

                        <?php if (!empty($sports) && is_array($sports)) :

                            foreach ($sports as $sport) :

                                $sport_title = isset($sport['sport_title'])   ? $sport['sport_title']   : '';
                                $fees        = isset($sport['fees'])          ? $sport['fees']          : '';
                                $days        = isset($sport['training_days']) ? $sport['training_days'] : [];
                                $description = isset($sport['text'])          ? $sport['text']          : '';
                                $link        = isset($sport['link'])          ? $sport['link']          : '';

                                // WhatsApp (raw from ACF)
                                $whatsapp_raw = isset($sport['whatsapp']) ? trim($sport['whatsapp']) : '';
                                $whatsapp_url = '';
                                $wa_number    = ''; // normalized WA number used for API / hidden field

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
                                if (!empty($days) && is_array($days)) {
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

                                <!-- Sport Card (branch view) -->
                                <!-- Sport Card (branch view) -->
                                <div class="sport-card js-scroll-up">
                                    <div class="sport-card-inner">
                                        <div class="row">
                                            <div class="col-12">
                                                <?php if ($sport_title) : ?>
                                                    <h3 class="sport-player-name mb-3" style="color:#000">
                                                        <?php echo esc_html($sport_title); ?>
                                                    </h3>
                                                <?php endif; ?>
                                            </div>
                                            <div class="col-md-6 col-sm-12">

                                                <?php if ($sport_img_url) : ?>
                                                    <div class="sport-photo">
                                                        <img
                                                            src="<?php echo esc_url($sport_img_url); ?>"
                                                            alt="<?php echo esc_attr($sport_title); ?>"
                                                            class="sport-img img-fluid">
                                                    </div>
                                                <?php endif; ?>

                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="sport-meta">

                                                    <?php if ($fees) : ?>
                                                        <div class="meta-row">
                                                            <span class="meta-label"><?php _e('الرسوم:', 'main-theme'); ?></span>
                                                            <span class="meta-value"><?php echo esc_html($fees); ?></span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if (!empty($day_labels)) : ?>
                                                        <div class="meta-row">
                                                            <span class="meta-label"><?php _e('أيام التدريب:', 'main-theme'); ?></span>
                                                            <span class="meta-value">
                                                                <?php echo esc_html(implode('، ', $day_labels)); ?>
                                                            </span>
                                                        </div>
                                                    <?php endif; ?>

                                                    <?php if ($branch_name) : ?>
                                                        <div class="meta-row">
                                                            <span class="meta-label"><?php _e('الفرع:', 'main-theme'); ?></span>
                                                            <span class="meta-value"><?php echo esc_html($branch_name); ?></span>
                                                        </div>
                                                    <?php endif; ?>

                                                </div>
                                            </div>



                                            <!-- REST OF CONTENT (col-md-12 col-sm-12) -->
                                            <div class="col-md-12 col-sm-12">

                                                <!-- Meta rows -->


                                                <!-- Description -->
                                                <?php if (!empty($description)) : ?>
                                                    <div class="sport-bio mt-3" style="color:#000">
                                                        <?php echo wp_kses_post($description); ?>
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Buttons -->
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="sport-actions mt-3">

                                                        <div class="sport-actions-icons">

                                                            <?php if ($location_url) : ?>
                                                                <a href="<?php echo esc_url($location_url); ?>"
                                                                    target="_blank"
                                                                    class="btn-location"
                                                                    rel="noopener">
                                                                    <i class="fas fa-map-marker-alt"></i>
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if ($link): ?>
                                                                <a href="<?php echo esc_url($link); ?>"
                                                                    target="_blank"
                                                                    rel="noopener"
                                                                    class="btn-share"
                                                                    data-copy="<?php echo esc_attr($link); ?>"
                                                                    title="<?php esc_attr_e('نسخ رابط الموقع', 'main-theme'); ?>">
                                                                    <i class="fa fa-share"></i>
                                                                </a>
                                                            <?php endif; ?>

                                                            <?php if ($whatsapp_url) : ?>
                                                                <a href="<?php echo esc_url($whatsapp_url); ?>"
                                                                    target="_blank"
                                                                    class="btn-whatsapp"
                                                                    rel="noopener">
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

                                            </div>

                                        </div><!-- /.row -->
                                    </div><!-- /.sport-card-inner -->
                                </div><!-- /.sport-card -->


                            <?php
                            endforeach; // end sports foreach
                        else :
                            ?>
                            <p class="text-white-80">
                                <?php _e('لا توجد رياضات مضافة لهذا الفرع حتى الآن.', 'main-theme'); ?>
                            </p>
                        <?php endif; ?>

                    </div><!-- /.academy-branch -->

                <?php endif; // end branch vs academy mode 
                ?>

            <?php else : ?>
                <p class="text-center text-white-80">
                    <?php _e('لا توجد فروع مضافة لهذه الأكاديمية حالياً.', 'main-theme'); ?>
                </p>
            <?php endif; ?>

        </div>
    </section>


    <!-- ==================== MODAL (used in branch view) ==================== -->
    <div id="academy-register-modal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3"><?php _e('تسجيل في الأكاديمية', 'main-theme'); ?></h3>

                <form id="academy-register-form" novalidate>
                    <input type="hidden" name="action" value="submit_academy_registration">
                    <input type="hidden" name="academy_id" value="<?php echo esc_attr(get_the_ID()); ?>">
                    <input type="hidden" name="branch" id="branch_name">
                    <input type="hidden" name="sport" id="sport_name">
                    <input type="hidden" name="academy_whatsapp" id="academy_whatsapp">
                    <input type="hidden" name="security" value="<?php echo esc_attr(wp_create_nonce('academy_register_nonce')); ?>">

                    <input type="text" name="name" class="form-control mb-3" placeholder="<?php esc_attr_e('الاسم الكامل', 'main-theme'); ?>" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="<?php esc_attr_e('البريد الإلكتروني', 'main-theme'); ?>" required>

                    <!-- Phone with fixed 971 prefix -->
                    <div class="mb-3">
                        <label class="form-label d-block"><?php _e('رقم الهاتف', 'main-theme'); ?></label>
                        <div class="input-group">
                            <span class="input-group-text">+971</span>
                            <input
                                type="tel"
                                name="phone_suffix"
                                class="form-control"
                                placeholder="<?php esc_attr_e('رقم الهاتف بدون 0 الأولى', 'main-theme'); ?>"
                                inputmode="tel"
                                dir="ltr"
                                required>
                        </div>
                        <input type="hidden" name="phone" id="full_phone">
                    </div>

                    <label><?php _e('تاريخ الميلاد', 'main-theme'); ?></label>
                    <input type="date" name="dob" class="form-control mb-4" required placeholder="<?php esc_attr_e('تاريخ الميلاد', 'main-theme'); ?>">

                    <button type="submit" class="btn btn-red w-100">
                        <?php _e('إرسال التسجيل', 'main-theme'); ?>
                    </button>
                </form>

            </div>
        </div>
    </div>


    <!-- ==================== JS ==================== -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const ajaxUrl = "<?php echo esc_url(admin_url('admin-ajax.php')); ?>";
            const genericError = "<?php echo esc_js(__('حدث خطأ، حاول مرة أخرى.', 'main-theme')); ?>";
            const okLabel = "<?php echo esc_js(__('تم', 'main-theme')); ?>";
            const copySuccessMsg = "<?php echo esc_js(__('تم نسخ الرابط', 'main-theme')); ?>";
            const copyFailMsg = "<?php echo esc_js(__('تعذر نسخ الرابط، حاول مرة أخرى.', 'main-theme')); ?>";
            const connErrorMsg = "<?php echo esc_js(__('خطأ في الاتصال، حاول مرة أخرى.', 'main-theme')); ?>";

            /* ---------- Modal ---------- */
            const modalEl = document.getElementById('academy-register-modal');
            const modal = (modalEl && typeof bootstrap !== 'undefined') ?
                new bootstrap.Modal(modalEl) :
                null;

            // Open modal (branch view)
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

            /* ---------- Submit AJAX ---------- */
            const form = document.getElementById('academy-register-form');
            if (form) {
                form.addEventListener('submit', async function(e) {
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
                    const fullPhone = form.querySelector('#full_phone');

                    if (suffixInput && fullPhone) {
                        let suffix = suffixInput.value || '';
                        suffix = suffix.replace(/\D+/g, ''); // keep digits only
                        suffix = suffix.replace(/^0+/, ''); // remove leading zeros
                        fullPhone.value = suffix ? ('971' + suffix) : '';
                    }

                    const data = new FormData(form);

                    let response;
                    try {
                        response = await fetch(ajaxUrl, {
                            method: 'POST',
                            body: data,
                            credentials: 'same-origin'
                        });
                    } catch (networkError) {
                        setLoading(false);

                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'error',
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
                            icon: result.success ? 'success' : 'error',
                            title: result.message || '',
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

            /* ---------- Copy to clipboard (share button) ---------- */
            document.querySelectorAll('.btn-share').forEach(function(btn) {
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
                                confirmButtonText: okLabel
                            });
                        } else {
                            alert(copyFailMsg);
                        }
                    };

                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(textToCopy)
                            .then(showSuccess)
                            .catch(showFail);
                    } else {
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
                scrollElements.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>
<?php
endwhile;
get_footer();
