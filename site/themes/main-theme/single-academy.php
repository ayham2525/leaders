<?php
get_header();

while (have_posts()) : the_post();
    $banner = get_the_post_thumbnail_url(get_the_ID(), 'full');
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

            <?php if (have_rows('academy_info')): ?>
                <?php while (have_rows('academy_info')): the_row();

                    $branch_name  = get_sub_field('branch');
                    $location_url = get_sub_field('location');

                ?>
                    <div class="academy-branch mb-5">

                        <!-- Branch Title -->
                        <h2 class="branch-title text-white mb-4">
                            <i class="fas fa-map-marker-alt text-red ml-2"></i>
                            <?php echo esc_html($branch_name); ?>
                        </h2>

                        <?php if (have_rows('sports')): ?>
                            <?php while (have_rows('sports')): the_row();

                                $sport_title = get_sub_field('sport_title');
                                $fees        = get_sub_field('fees');
                                $days        = get_sub_field('training_days');

                                $sport_img_id  = get_sub_field('image');
                                $sport_img_url = wp_get_attachment_image_url($sport_img_id, 'full');

                                $day_labels = (!empty($days))
                                    ? array_map(fn($d) => $d['label'] ?? $d, $days)
                                    : [];
                            ?>

                                <!-- Sport Card -->
                                <div class="sport-card mb-4">
                                    <div class="row g-4 align-items-center">

                                        <!-- IMAGE -->
                                        <?php if ($sport_img_url): ?>
                                            <div class="col-md-5 col-sm-12">
                                                <div class="sport-img-wrapper">
                                                    <img src="<?php echo esc_url($sport_img_url); ?>"
                                                        class="sport-img"
                                                        alt="<?php echo esc_attr($sport_title); ?>">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- CONTENT -->
                                        <div class="col-md-7 col-sm-12">

                                            <h4 class="sport-title text-white mb-3">
                                                <i class="fas fa-trophy text-red ml-2"></i>
                                                <?php echo esc_html($sport_title); ?>
                                            </h4>

                                            <?php if ($fees): ?>
                                                <p class="mb-2 text-white">
                                                    <i class="fas fa-money-bill-wave text-red ml-2"></i>
                                                    <strong>الرسوم:</strong> <?php echo esc_html($fees); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($day_labels)): ?>
                                                <p class="mb-3 text-white">
                                                    <i class="fas fa-calendar-alt text-red ml-2"></i>
                                                    <strong>الأيام:</strong> <?php echo esc_html(implode('، ', $day_labels)); ?>
                                                </p>
                                            <?php endif; ?>
                                            <?php if (!empty(get_sub_field('text'))): ?>
                                                <div class="mb-3 text-white">

                                                    <?php echo get_sub_field('text'); ?>
                                                </div>
                                            <?php endif; ?>

                                            <!-- BUTTONS -->
                                            <div class="sport-buttons">

                                                <!-- Map Button -->
                                                <?php if ($location_url): ?>
                                                    <a href="<?php echo esc_url($location_url); ?>"
                                                        target="_blank"
                                                        class="btn btn-location">
                                                        عرض الموقع على الخريطة
                                                    </a>
                                                <?php endif; ?>

                                                <!-- Booking Button -->
                                                <button class="btn btn-book open-register"
                                                    data-branch="<?php echo esc_attr($branch_name); ?>"
                                                    data-sport="<?php echo esc_attr($sport_title); ?>">
                                                    حجز
                                                </button>

                                            </div>

                                        </div>

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
    <div id="academy-register-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3">تسجيل في الأكاديمية</h3>

                <form id="academy-register-form">
                    <input type="hidden" name="action" value="submit_academy_registration">
                    <input type="hidden" name="academy_id" value="<?php echo get_the_ID(); ?>">
                    <input type="hidden" name="branch" id="branch_name">
                    <input type="hidden" name="sport" id="sport_name">

                    <input type="text" name="name" class="form-control mb-3" placeholder="الاسم الكامل" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required>
                    <input type="tel" name="phone" class="form-control mb-3" placeholder="رقم الهاتف" required>
                    <input type="date" name="dob" class="form-control mb-4" required>

                    <button type="submit" class="btn btn-red w-100">إرسال التسجيل</button>
                </form>

            </div>
        </div>
    </div>


    <!-- ==================== JS ==================== -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const modal = new bootstrap.Modal(document.getElementById('academy-register-modal'));

            // Open modal
            document.querySelectorAll(".open-register").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("branch_name").value = btn.dataset.branch;
                    document.getElementById("sport_name").value = btn.dataset.sport;
                    modal.show();
                });
            });

            // Submit to backend
            const form = document.getElementById("academy-register-form");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();

                let data = new FormData(form);

                const response = await fetch("<?php echo admin_url('admin-ajax.php'); ?>", {
                    method: "POST",
                    body: data
                });

                const result = await response.json();

                Swal.fire({
                    icon: result.success ? "success" : "error",
                    title: result.message,
                    confirmButtonText: "تم"
                });

                if (result.success) {
                    form.reset();
                    modal.hide();
                }
            });
        });
    </script>



<?php
endwhile;
?>

<?php
get_footer();
?>