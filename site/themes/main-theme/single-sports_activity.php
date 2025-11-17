<?php
get_header();

while (have_posts()) : the_post();
    $banner = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

    <!-- ==================== BANNER ==================== -->
    <section class="activity-banner" style="background-image:url('<?php echo esc_url($banner); ?>');">
        <div class="overlay"></div>
        <div class="container text-center">
            <h1 class="activity-title-page"><?php the_title(); ?></h1>
            <div class="divider mx-auto mt-3"></div>
        </div>
    </section>

    <!-- ==================== ACTIVITY DETAILS ==================== -->
    <section class="activity-details py-5">
        <div class="container">

            <?php if (have_rows('activities_info')): ?>
                <?php while (have_rows('activities_info')): the_row();

                    $branch_name  = get_sub_field('branch');
                    $location_url = get_sub_field('location');
                ?>
                    <div class="activity-branch mb-5">

                        <!-- Branch Title -->
                        <h2 class="branch-title text-white mb-4">
                            <i class="fas fa-map-marker-alt text-gold ms-2"></i>
                            <?php echo esc_html($branch_name); ?>
                        </h2>

                        <?php if (have_rows('sports')): ?>
                            <?php while (have_rows('sports')): the_row();

                                $sport_title = get_sub_field('sport_title');
                                $fees        = get_sub_field('fees');
                                $days        = get_sub_field('training_days');
                                $whatsapp    = get_sub_field('whatsapp');
                                $text        = get_sub_field('text');

                                // IMAGE WITH FOCAL POINT SUPPORT
                                $image = get_sub_field('image');
                                $sport_img_url = "";
                                $img_left = 50;
                                $img_top  = 50;

                                if (!empty($image['id'])) {
                                    $src = wp_get_attachment_image_src($image['id'], 'full');
                                    if (!empty($src[0])) {
                                        $sport_img_url = $src[0];
                                    }
                                }

                                if (isset($image['left'])) $img_left = $image['left'];
                                if (isset($image['top']))  $img_top  = $image['top'];

                                $day_labels = (!empty($days))
                                    ? array_map(fn($d) => $d['label'] ?? $d, $days)
                                    : [];
                            ?>

                                <!-- Sport Card -->
                                <div class="activity-sport-card mb-4">
                                    <div class="row g-4 align-items-center">

                                        <!-- IMAGE -->
                                        <?php if ($sport_img_url): ?>
                                            <div class="col-md-5 col-sm-12">
                                                <div class="activity-img-wrapper"
                                                    style="
                                                    background-image:url('<?php echo esc_url($sport_img_url); ?>');
                                                    background-position: <?php echo esc_attr($img_left); ?>% <?php echo esc_attr($img_top); ?>%;
                                                    background-size: cover;
                                                    background-repeat: no-repeat;
                                                    aspect-ratio: 16/9;
                                                    border-radius: 14px;
                                                ">
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <!-- CONTENT -->
                                        <div class="col-md-7 col-sm-12">

                                            <h4 class="sport-title text-white mb-3">
                                                <i class="fas fa-medal text-gold ms-2"></i>
                                                <?php echo esc_html($sport_title); ?>
                                            </h4>

                                            <?php if ($fees): ?>
                                                <p class="mb-2 text-white">
                                                    <i class="fas fa-money-bill text-gold ms-2"></i>
                                                    <strong>الرسوم:</strong> <?php echo esc_html($fees); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($day_labels)): ?>
                                                <p class="mb-3 text-white">
                                                    <i class="fas fa-calendar text-gold ms-2"></i>
                                                    <strong>الأيام:</strong>
                                                    <?php echo esc_html(implode('، ', $day_labels)); ?>
                                                </p>
                                            <?php endif; ?>

                                            <?php if (!empty($text)): ?>
                                                <div class="mb-3 text-white"><?php echo $text; ?></div>
                                            <?php endif; ?>

                                            <!-- BUTTONS -->
                                            <div class="activity-buttons">

                                                <?php if ($location_url): ?>
                                                    <a href="<?php echo esc_url($location_url); ?>"
                                                        target="_blank"
                                                        class="btn btn-location">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        عرض الموقع
                                                    </a>
                                                <?php endif; ?>

                                                <!-- REGISTRATION BTN -->
                                                <button class="btn btn-book open-activity-register"
                                                    data-branch="<?php echo esc_attr($branch_name); ?>"
                                                    data-sport="<?php echo esc_attr($sport_title); ?>">
                                                    <i class="fas fa-calendar-check"></i>
                                                    تسجيل
                                                </button>

                                                <?php if ($whatsapp): ?>
                                                    <a href="https://wa.me/<?php echo preg_replace('/\D/', '', $whatsapp); ?>"
                                                        target="_blank"
                                                        class="btn btn-activity-whatsapp">
                                                        <i class="fab fa-whatsapp"></i>
                                                        واتساب
                                                    </a>
                                                <?php endif; ?>

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
    <div id="activity-register-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content form-card p-4">

                <h3 class="text-center text-red mb-3">حجز الفعالية الرياضية</h3>

                <form id="activity-register-form">

                    <!-- Correct AJAX action -->
                    <input type="hidden" name="action" value="submit_sports_registration">

                    <!-- Correct Activity ID -->
                    <input type="hidden" name="activity_id" value="<?php echo get_the_ID(); ?>">

                    <!-- Dynamic fields -->
                    <input type="hidden" name="branch" id="activity_branch_name">
                    <input type="hidden" name="sport" id="activity_sport_name">

                    <input type="text" name="name" class="form-control mb-3" placeholder="الاسم الكامل" required>
                    <input type="email" name="email" class="form-control mb-3" placeholder="البريد الإلكتروني" required>
                    <input type="tel" name="phone" class="form-control mb-3" placeholder="رقم الهاتف" required>
                    <input type="date" name="dob" class="form-control mb-4" required>

                    <button type="submit" class="btn btn-red w-100">إرسال التسجيل</button>
                </form>

            </div>
        </div>
    </div>



    <!-- ==================== AJAX ==================== -->
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            const modal = new bootstrap.Modal(document.getElementById('activity-register-modal'));

            // Open modal
            document.querySelectorAll(".open-activity-register").forEach(btn => {
                btn.addEventListener("click", () => {
                    document.getElementById("activity_branch_name").value = btn.dataset.branch;
                    document.getElementById("activity_sport_name").value = btn.dataset.sport;
                    modal.show();
                });
            });

            // Submit AJAX
            document.getElementById("activity-register-form").addEventListener("submit", async (e) => {
                e.preventDefault();

                let data = new FormData(e.target);

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
                    e.target.reset();
                    modal.hide();
                }
            });
        });
    </script>

<?php endwhile; ?>
<?php get_footer(); ?>