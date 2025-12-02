<?php

/**
 * Theme functions
 *
 * Textdomain: leaderssports
 */

/**
 * Detect if the current singular post content needs 360/VR assets.
 */
function leaders_needs_360_assets(): bool
{
    if (!is_singular()) return false;
    global $post;
    if (empty($post) || empty($post->post_content)) return false;

    $c = $post->post_content;
    return has_shortcode($c, 'photosphere')
        || has_shortcode($c, 'psv')
        || has_shortcode($c, 'aframe')
        || stripos($c, '<a-scene') !== false;
}

/**
 * Enqueue styles
 */
add_action('wp_enqueue_scripts', function () {
    $theme_ver = wp_get_theme()->get('Version') ?: '1.0.0';

    // ===============================
    // MAIN THEME STYLES
    // ===============================
    $main_css_rel = '/assets/style/css/main-theme.css';
    $main_css_abs = get_stylesheet_directory() . $main_css_rel;
    $main_ver     = file_exists($main_css_abs) ? filemtime($main_css_abs) : $theme_ver;

    wp_enqueue_style(
        'leaders-main',
        get_stylesheet_directory_uri() . $main_css_rel,
        [],
        $main_ver
    );

    // ===============================
    // THIRD-PARTY STYLES
    // ===============================
    wp_enqueue_style('leaders-fontawesome', 'https://use.fontawesome.com/releases/v5.15.4/css/all.css', [], '5.15.4');
    wp_enqueue_style('leaders-owl-carousel', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css', [], '2.3.4');
    wp_enqueue_style('leaders-owl-theme', 'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css', ['leaders-owl-carousel'], '2.3.4');
    wp_enqueue_style('leaders-fancybox', 'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css', [], '3.5.7');

    // ===============================
    // BOOTSTRAP RTL/LTR
    // ===============================
    if (defined('ICL_LANGUAGE_CODE') && ICL_LANGUAGE_CODE === 'ar') {
        wp_enqueue_style('leaders-bootstrap-rtl', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css', [], '5.0.2');
    } else {
        wp_enqueue_style('leaders-bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css', [], '5.3.2');
    }

    // ===============================
    // SWIPER CSS (for banner slide)
    // ===============================
    wp_enqueue_style(
        'leaders-swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css',
        [],
        '11.0.0'
    );

    // ===============================
    // 360° Viewer CSS (conditional)
    // ===============================
    if (function_exists('leaders_needs_360_assets') && leaders_needs_360_assets()) {
        wp_enqueue_style(
            'leaders-photo-sphere-css',
            'https://cdnjs.cloudflare.com/ajax/libs/photo-sphere-viewer/4.0.0/photo-sphere-viewer.min.css',
            [],
            '4.0.0'
        );
    }
}, 10);


add_action('wp_enqueue_scripts', function () {
    $theme_ver = wp_get_theme()->get('Version') ?: '1.0.0';

    // Core jQuery
    wp_enqueue_script('jquery');

    // Bootstrap Bundle
    wp_enqueue_script(
        'leaders-bootstrap',
        'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js',
        [],
        '5.3.2',
        true
    );

    // SweetAlert
    wp_enqueue_script('sweetalert2', 'https://cdn.jsdelivr.net/npm/sweetalert2@11', [], '11', true);

    // Owl Carousel
    wp_enqueue_script(
        'leaders-owl-carousel',
        'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js',
        ['jquery'],
        '2.3.4',
        true
    );

    // Fancybox
    wp_enqueue_script(
        'leaders-fancybox',
        'https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js',
        ['jquery'],
        '3.5.7',
        true
    );

    wp_enqueue_script(
        'leaders-swiper-js',
        'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js',
        [],
        '11.0.0',
        true
    );

    // GSAP (currently disabled)
    // wp_enqueue_script(
    //     'leaders-gsap',
    //     'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/gsap.min.js',
    //     [],
    //     '3.12.5',
    //     true
    // );

    // wp_enqueue_script(
    //     'leaders-gsap-scrolltrigger',
    //     'https://cdn.jsdelivr.net/npm/gsap@3.12.5/dist/ScrollTrigger.min.js',
    //     ['leaders-gsap'],
    //     '3.12.5',
    //     true
    // );

    $testimonials_rel = '/assets/js/testimonials-slider.js';
    $testimonials_abs = get_stylesheet_directory() . $testimonials_rel;

    if (file_exists($testimonials_abs)) {
        wp_enqueue_script(
            'leaders-testimonials-slider',
            get_stylesheet_directory_uri() . $testimonials_rel,
            ['leaders-swiper-js'],
            filemtime($testimonials_abs),
            true
        );
    }

    $sports_activites_rel = '/assets/js/ls-sports-slider.js';
    $sports_activites_abs = get_stylesheet_directory() . $sports_activites_rel;

    if (file_exists($sports_activites_abs)) {
        wp_enqueue_script(
            'sports_activites-slider',
            get_stylesheet_directory_uri() . $sports_activites_rel,
            ['leaders-swiper-js'],
            filemtime($sports_activites_abs),
            true
        );
    }

    $scroll_rel = '/assets/js/scroll-up.js';
    $scroll_abs = get_stylesheet_directory() . $scroll_rel;

    if (file_exists($scroll_abs)) {
        wp_enqueue_script(
            'page-banner',
            get_stylesheet_directory_uri() . $scroll_rel,
            ['leaders-swiper-js'],
            filemtime($scroll_abs),
            true
        );
    }

    // ===============================
    // Banner Slider JS
    // ===============================
    $banner_rel = '/assets/js/home-banner-slider.js';
    $banner_abs = get_stylesheet_directory() . $banner_rel;

    if (file_exists($banner_abs)) {
        wp_enqueue_script(
            'leaders-home-banner-slider',
            get_stylesheet_directory_uri() . $banner_rel,
            ['leaders-swiper-js'],
            filemtime($banner_abs),
            true
        );
    } else {
        if (WP_DEBUG) error_log('[leaderssports] Missing JS: ' . $banner_abs);
    }

    // ===============================
    // News Slider JS
    // ===============================
    $news_rel = '/assets/js/news-slider.js';
    $news_abs = get_stylesheet_directory() . $news_rel;

    if (file_exists($news_abs)) {
        wp_enqueue_script(
            'leaders-news-slider',
            get_stylesheet_directory_uri() . $news_rel,
            ['jquery', 'leaders-owl-carousel'],
            filemtime($news_abs),
            true
        );
    }

    // ===============================
    // Tryouts
    // ===============================
    $tryouts_rel = '/assets/js/tryouts.js';
    $tryouts_abs = get_stylesheet_directory() . $tryouts_rel;

    if (file_exists($tryouts_abs)) {
        wp_enqueue_script(
            'leaders-tryouts-slider',
            get_stylesheet_directory_uri() . $tryouts_rel,
            ['leaders-swiper-js'],
            filemtime($tryouts_abs),
            true
        );
    }

    // ===============================
    // Header JS
    // ===============================
    $header_rel = '/assets/js/header.js';
    $header_abs = get_stylesheet_directory() . $header_rel;

    if (file_exists($header_abs)) {
        wp_enqueue_script(
            'leaders-header-js',
            get_stylesheet_directory_uri() . $header_rel,
            [],
            filemtime($header_abs),
            true
        );
    }

    // ===============================
    // About Academy Anim
    // ===============================
    $about_rel = '/assets/js/about-academy-anim.js';
    $about_abs = get_stylesheet_directory() . $about_rel;

    if (file_exists($about_abs)) {
        wp_enqueue_script(
            'leaders-about-anim',
            get_stylesheet_directory_uri() . $about_rel,
            ['leaders-gsap', 'leaders-gsap-scrolltrigger'], // keep if you enable GSAP
            filemtime($about_abs),
            true
        );
    }

    // ===============================
    // 360° Viewer (conditional)
    // ===============================
    if (function_exists('leaders_needs_360_assets') && leaders_needs_360_assets()) {
        wp_enqueue_script('leaders-three', 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js', [], '0.128.0', true);
        wp_enqueue_script('leaders-photo-sphere', 'https://cdnjs.cloudflare.com/ajax/libs/photo-sphere-viewer/4.0.0/photo-sphere-viewer.min.js', ['leaders-three'], '4.0.0', true);
        wp_enqueue_script('leaders-aframe', 'https://aframe.io/releases/0.5.0/aframe.min.js', [], '0.5.0', true);
    }
}, 10);

/**
 * Resource hints for external CDNs
 */
add_filter('wp_resource_hints', function ($urls, $relation_type) {
    if (in_array($relation_type, ['preconnect', 'dns-prefetch'], true)) {
        $urls = array_unique(array_merge($urls, [
            'https://cdn.jsdelivr.net',
            'https://cdnjs.cloudflare.com',
            'https://use.fontawesome.com',
            'https://aframe.io',
        ]));
    }
    return $urls;
}, 10, 2);

function leaderssports_enqueue_icons()
{
    wp_enqueue_style('line-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css', [], '1.3.0');
}
add_action('wp_enqueue_scripts', 'leaderssports_enqueue_icons');

/**
 * Safe post view counter
 */
function leaders_set_post_views($post_id)
{
    $key = 'post_views_count';
    $count = (int) get_post_meta($post_id, $key, true);
    update_post_meta($post_id, $key, $count + 1);
}
add_action('wp', function () {
    if (!is_admin() && is_singular('post')) {
        $post = get_queried_object();
        if (!empty($post->ID)) leaders_set_post_views($post->ID);
    }
});

/**
 * Remove author fields from oEmbed response
 */
add_filter('oembed_response_data', function ($data) {
    unset($data['author_url'], $data['author_name']);
    return $data;
});

/**
 * ACF: Options Page
 */
add_action('acf/init', function () {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title' => __('Options', 'leaderssports'),
            'menu_title' => __('Options', 'leaderssports'),
            'menu_slug'  => 'theme-general-settings',
            'capability' => 'edit_posts',
            'redirect'   => false,
        ]);
    }
});

/**
 * ACF Flexible Content Title
 */
add_filter('acf/fields/flexible_content/layout_title/name=main_content', function ($title, $field, $layout, $i) {
    $title = $layout['label'];
    if ($text = get_sub_field('section_title')) {
        $title .= ' <b>(' . esc_html($text) . ')</b>';
    } elseif ($text = get_sub_field('title')) {
        $title .= ' <b>(' . esc_html($text) . ')</b>';
    }
    return $title;
}, 10, 4);

/**
 * Login Logo
 */
add_action('login_enqueue_scripts', function () {
    $logo = esc_url(get_stylesheet_directory_uri() . '/assets/images/logo.png'); ?>
    <style>
        body.login div#login h1 a {
            background-image: url('<?php echo $logo; ?>');
            background-size: contain;
            width: 100%;
        }
    </style>
<?php });

/**
 * Replace CF7 Submit Button
 */
add_filter('wpcf7_form_elements', function ($form) {
    return preg_replace_callback(
        '/<input([^>]*)class="([^"]*)wpcf7-submit([^"]*)"([^>]*)value="([^"]+)"([^>]*)>/',
        function ($m) {
            return '<button' . $m[1] . 'class="' . $m[2] . 'wpcf7-submit' . $m[3] . '"' . $m[4] . '>'
                . esc_html($m[5])
                . ' <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 21 21" fill="none" aria-hidden="true" focusable="false">'
                . '<path d="M14.6667 7.1665L18 10.4998M18 10.4998L14.6667 13.8332M18 10.4998L3 10.4998" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"></path>'
                . '</svg></button>';
        },
        $form
    );
});

/**
 * Allow SVG upload (admins only)
 */
add_filter('upload_mimes', function ($mimes) {
    if (current_user_can('manage_options')) $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});
add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    $ext = isset($data['ext']) ? $data['ext'] : '';
    if ('svg' === $ext && current_user_can('manage_options')) {
        $data['type'] = 'image/svg+xml';
        $data['ext']  = 'svg';
    }
    return $data;
}, 10, 4);

/**
 * Helpers
 */
function leaders_custom_excerpt($word_limit)
{
    $content = wp_strip_all_tags(get_the_content(null, false), true);
    $words   = preg_split('/\s+/', trim($content));
    if (!$words) return '';
    return (count($words) > $word_limit)
        ? implode(' ', array_slice($words, 0, $word_limit)) . '…'
        : implode(' ', $words);
}

function leaders_truncated_title($limit = 6)
{
    $title = get_the_title();
    $words = preg_split('/\s+/', trim($title));
    return (count($words) > $limit)
        ? implode(' ', array_slice($words, 0, $limit)) . '…'
        : $title;
}

/**
 * Register Custom Post Type: Academy (الأكاديميات)
 */
function leaderssports_register_academy_cpt()
{

    $labels = array(
        'name'                  => _x('Academies', 'Post Type General Name', 'leaderssports'),
        'singular_name'         => _x('Academy', 'Post Type Singular Name', 'leaderssports'),
        'menu_name'             => __('Academies', 'leaderssports'),
        'name_admin_bar'        => __('Academy', 'leaderssports'),
        'add_new'               => __('Add New', 'leaderssports'),
        'add_new_item'          => __('Add New Academy', 'leaderssports'),
        'edit_item'             => __('Edit Academy', 'leaderssports'),
        'new_item'              => __('New Academy', 'leaderssports'),
        'view_item'             => __('View Academy', 'leaderssports'),
        'view_items'            => __('View Academies', 'leaderssports'),
        'search_items'          => __('Search Academies', 'leaderssports'),
        'not_found'             => __('No academies found', 'leaderssports'),
        'not_found_in_trash'    => __('No academies found in Trash', 'leaderssports'),
        'all_items'             => __('All Academies', 'leaderssports'),
        'archives'              => __('Academy Archives', 'leaderssports'),
        'attributes'            => __('Academy Attributes', 'leaderssports'),
        'insert_into_item'      => __('Insert into academy', 'leaderssports'),
        'uploaded_to_this_item' => __('Uploaded to this academy', 'leaderssports'),
        'featured_image'        => __('Featured Image', 'leaderssports'),
        'set_featured_image'    => __('Set featured image', 'leaderssports'),
        'remove_featured_image' => __('Remove featured image', 'leaderssports'),
        'use_featured_image'    => __('Use as featured image', 'leaderssports'),
    );

    $args = array(
        'label'                 => __('Academies', 'leaderssports'),
        'description'           => __('Manage all academies and their information', 'leaderssports'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'excerpt', 'revisions'),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-building',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'capability_type'       => 'post',
        'rewrite'               => array('slug' => 'academy', 'with_front' => false),
    );

    register_post_type('academy', $args);
}
add_action('init', 'leaderssports_register_academy_cpt');

/**
 * Register Custom Post Type: Academy Registrations
 */
function leaderssports_register_academy_registration_cpt()
{
    $labels = array(
        'name'                  => __('Academy Registrations', 'leaderssports'),
        'singular_name'         => __('Academy Registration', 'leaderssports'),
        'menu_name'             => __('Academy Registrations', 'leaderssports'),
        'name_admin_bar'        => __('Academy Registration', 'leaderssports'),
        'add_new'               => __('Add New', 'leaderssports'),
        'add_new_item'          => __('Add New Registration', 'leaderssports'),
        'edit_item'             => __('Edit Registration', 'leaderssports'),
        'new_item'              => __('New Registration', 'leaderssports'),
        'view_item'             => __('View Registration', 'leaderssports'),
        'all_items'             => __('All Registrations', 'leaderssports'),
        'search_items'          => __('Search Registrations', 'leaderssports'),
        'not_found'             => __('No registrations found', 'leaderssports'),
        'not_found_in_trash'    => __('No registrations found in Trash', 'leaderssports'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-forms',
        'supports'           => array('title', 'custom-fields'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
    );

    register_post_type('academy_registration', $args);
}
add_action('init', 'leaderssports_register_academy_registration_cpt');

/**
 * Add Registration Details Meta Box
 */
add_action('add_meta_boxes', function () {
    add_meta_box(
        'academy_registration_full_info',
        __('Registration Information', 'leaderssports'),
        'leaderssports_registration_full_info_box',
        'academy_registration',
        'normal',
        'high'
    );
});

function leaderssports_registration_full_info_box($post)
{
    wp_nonce_field('save_registration_status', 'registration_status_nonce');

    $fields = [
        'academy_id' => __('Academy', 'leaderssports'),
        'name'       => __('Name', 'leaderssports'),
        'email'      => __('Email', 'leaderssports'),
        'phone'      => __('Phone', 'leaderssports'),
        'dob'        => __('Date of Birth', 'leaderssports'),
        'branch'     => __('Branch', 'leaderssports'),
        'sport'      => __('Sport', 'leaderssports'),
    ];

    echo '<table class="widefat striped">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        if ($key === 'academy_id' && $value) {
            $value = '<a href="' . esc_url(get_edit_post_link($value)) . '" target="_blank">' . esc_html(get_the_title($value)) . '</a>';
        }
        if (empty($value)) {
            $value = '<em>' . __('Not Provided', 'leaderssports') . '</em>';
        }

        echo '<tr><th style="width:180px;">' . esc_html($label) . '</th><td>' . wp_kses_post($value) . '</td></tr>';
    }

    $status = get_post_meta($post->ID, 'status', true) ?: 'pending';
    echo '<tr><th><strong>' . __('Status', 'leaderssports') . '</strong></th><td>';
    echo '<select name="registration_status" id="registration_status" style="min-width:200px;">';
    echo '<option value="pending"' . selected($status, 'pending', false) . '>' . __('Pending', 'leaderssports') . '</option>';
    echo '<option value="approved"' . selected($status, 'approved', false) . '>' . __('Approved', 'leaderssports') . '</option>';
    echo '<option value="rejected"' . selected($status, 'rejected', false) . '>' . __('Rejected', 'leaderssports') . '</option>';
    echo '</select></td></tr></table>';
}

/**
 * Save Status on Update
 */
add_action('save_post_academy_registration', function ($post_id) {
    if (
        !isset($_POST['registration_status_nonce']) ||
        !wp_verify_nonce($_POST['registration_status_nonce'], 'save_registration_status')
    ) return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['registration_status'])) {
        update_post_meta($post_id, 'status', sanitize_text_field($_POST['registration_status']));
    }
});

/**
 * Admin Columns
 */
add_filter('manage_academy_registration_posts_columns', function ($columns) {
    $new = [];
    foreach ($columns as $key => $value) {
        $new[$key] = $value;
        if ($key === 'title') {
            $new['status']  = __('Status', 'leaderssports');
            $new['academy'] = __('Academy', 'leaderssports');
            $new['dob']     = __('DOB', 'leaderssports');
        }
    }
    return $new;
});

add_action('manage_academy_registration_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'status':
            $status = get_post_meta($post_id, 'status', true) ?: 'pending';
            $colors = ['approved' => '#28a745', 'rejected' => '#dc3545', 'pending' => '#ffc107'];
            echo '<span style="background:' . esc_attr($colors[$status]) . ';color:#fff;padding:2px 8px;border-radius:4px;">' . ucfirst($status) . '</span>';
            break;

        case 'academy':
            $academy_id = get_post_meta($post_id, 'academy_id', true);
            if ($academy_id) {
                echo '<a href="' . esc_url(get_edit_post_link($academy_id)) . '">' . esc_html(get_the_title($academy_id)) . '</a>';
            } else {
                echo '—';
            }
            break;

        case 'dob':
            echo esc_html(get_post_meta($post_id, 'dob', true) ?: '—');
            break;
    }
}, 10, 2);

/**
 * Export to CSV
 */
add_action('restrict_manage_posts', function () {
    if (get_current_screen()->post_type !== 'academy_registration') return;
    $export_url = add_query_arg([
        'post_type'  => 'academy_registration',
        'export_csv' => 1,
        '_wpnonce'   => wp_create_nonce('export_academy_registrations'),
    ]);
    echo '<a href="' . esc_url($export_url) . '" class="button button-primary" style="margin-left:10px;">' . __('Export CSV', 'leaderssports') . '</a>';
});

add_action('admin_init', function () {
    if (
        isset($_GET['export_csv'], $_GET['_wpnonce']) &&
        wp_verify_nonce($_GET['_wpnonce'], 'export_academy_registrations') &&
        current_user_can('manage_options')
    ) {
        $filename = 'academy-registrations-' . date('Y-m-d') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Email', 'Phone', 'DOB', 'Branch', 'Sport', 'Academy', 'Status', 'Date']);

        $query = new WP_Query(['post_type' => 'academy_registration', 'posts_per_page' => -1]);
        while ($query->have_posts()) {
            $query->the_post();
            $id = get_the_ID();
            fputcsv($output, [
                get_post_meta($id, 'name', true),
                get_post_meta($id, 'email', true),
                get_post_meta($id, 'phone', true),
                get_post_meta($id, 'dob', true),
                get_post_meta($id, 'branch', true),
                get_post_meta($id, 'sport', true),
                get_the_title(get_post_meta($id, 'academy_id', true)),
                get_post_meta($id, 'status', true),
                get_the_date('Y-m-d H:i', $id),
            ]);
        }
        fclose($output);
        exit;
    }
});

/**
 * Register Custom Post Type: Tryouts (تجارب الأداء)
 */
function leaderssports_register_tryouts_cpt()
{

    $labels = array(
        'name'                  => _x('Tryouts', 'Post Type General Name', 'leaderssports'),
        'singular_name'         => _x('Tryout', 'Post Type Singular Name', 'leaderssports'),
        'menu_name'             => __('Tryouts', 'leaderssports'),
        'name_admin_bar'        => __('Tryout', 'leaderssports'),
        'add_new'               => __('Add New', 'leaderssports'),
        'add_new_item'          => __('Add New Tryout', 'leaderssports'),
        'edit_item'             => __('Edit Tryout', 'leaderssports'),
        'new_item'              => __('New Tryout', 'leaderssports'),
        'view_item'             => __('View Tryout', 'leaderssports'),
        'view_items'            => __('View Tryouts', 'leaderssports'),
        'search_items'          => __('Search Tryouts', 'leaderssports'),
        'not_found'             => __('No tryouts found', 'leaderssports'),
        'not_found_in_trash'    => __('No tryouts found in Trash', 'leaderssports'),
        'all_items'             => __('All Tryouts', 'leaderssports'),
        'archives'              => __('Tryout Archives', 'leaderssports'),
        'attributes'            => __('Tryout Attributes', 'leaderssports'),
        'insert_into_item'      => __('Insert into tryout', 'leaderssports'),
        'uploaded_to_this_item' => __('Uploaded to this tryout', 'leaderssports'),
        'featured_image'        => __('Featured Image', 'leaderssports'),
        'set_featured_image'    => __('Set featured image', 'leaderssports'),
        'remove_featured_image' => __('Remove featured image', 'leaderssports'),
        'use_featured_image'    => __('Use as featured image', 'leaderssports'),
    );

    $args = array(
        'label'                 => __('Tryouts', 'leaderssports'),
        'description'           => __('Manage all sports tryouts and performance tests', 'leaderssports'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'revisions'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-megaphone',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'show_in_rest'          => true,
        'capability_type'       => 'post',
        'rewrite'               => array('slug' => 'tryouts', 'with_front' => false)
    );

    register_post_type('tryout', $args);
}
add_action('init', 'leaderssports_register_tryouts_cpt');

/**
 * Register Custom Post Type: Tryout Registrations
 */
function leaderssports_register_tryout_registration_cpt()
{
    $labels = array(
        'name'                  => __('Tryout Registrations', 'leaderssports'),
        'singular_name'         => __('Tryout Registration', 'leaderssports'),
        'menu_name'             => __('Tryout Registrations', 'leaderssports'),
        'name_admin_bar'        => __('Tryout Registration', 'leaderssports'),
        'add_new'               => __('Add New', 'leaderssports'),
        'add_new_item'          => __('Add New Registration', 'leaderssports'),
        'edit_item'             => __('Edit Registration', 'leaderssports'),
        'new_item'              => __('New Registration', 'leaderssports'),
        'view_item'             => __('View Registration', 'leaderssports'),
        'all_items'             => __('All Registrations', 'leaderssports'),
        'search_items'          => __('Search Registrations', 'leaderssports'),
        'not_found'             => __('No registrations found', 'leaderssports'),
        'not_found_in_trash'    => __('No registrations found in Trash', 'leaderssports'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'custom-fields'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'show_in_rest'       => false,
    );

    register_post_type('tryout_registration', $args);
}
add_action('init', 'leaderssports_register_tryout_registration_cpt');

add_action('add_meta_boxes', function () {
    add_meta_box(
        'tryout_registration_info',
        __('Tryout Registration Information', 'leaderssports'),
        'leaderssports_tryout_registration_box',
        'tryout_registration',
        'normal',
        'high'
    );
});

function leaderssports_tryout_registration_box($post)
{
    wp_nonce_field('save_tryout_registration_status', 'tryout_registration_nonce');

    $fields = [
        'tryout_id' => __('Tryout', 'leaderssports'),
        'name'      => __('Name', 'leaderssports'),
        'email'     => __('Email', 'leaderssports'),
        'phone'     => __('Phone', 'leaderssports'),
        'dob'       => __('Date of Birth', 'leaderssports'),
        'branch'    => __('Branch', 'leaderssports'),
        'sport'     => __('Sport', 'leaderssports'),
    ];

    echo '<table class="widefat striped">';

    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);

        if ($key === 'tryout_id' && $value) {
            $value = '<a href="' . get_edit_post_link($value) . '" target="_blank">' .
                get_the_title($value) . '</a>';
        }

        if (!$value) $value = '<em>' . __('Not Provided', 'leaderssports') . '</em>';

        echo "<tr><th style='width:170px;'>{$label}</th><td>{$value}</td></tr>";
    }

    $status = get_post_meta($post->ID, 'status', true) ?: 'pending';

    echo '<tr><th>' . __('Status', 'leaderssports') . '</th><td>';
    echo '<select name="tryout_status" style="min-width:200px;">';
    echo '<option value="pending"' . selected($status, 'pending', false) . '>Pending</option>';
    echo '<option value="approved"' . selected($status, 'approved', false) . '>Approved</option>';
    echo '<option value="rejected"' . selected($status, 'rejected', false) . '>Rejected</option>';
    echo '</select></td></tr>';

    echo '</table>';
}

/**
 * Register Custom Post Type: Sports Activities (الأنشطة الرياضية)
 */
function leaderssports_register_sports_activity_cpt()
{

    $labels = array(
        'name'                  => _x('Sports Activities', 'Post Type General Name', 'leaderssports'),
        'singular_name'         => _x('Sports Activity', 'Post Type Singular Name', 'leaderssports'),
        'menu_name'             => __('Sports Activities', 'leaderssports'),
        'name_admin_bar'        => __('Sports Activity', 'leaderssports'),
        'add_new'               => __('Add New', 'leaderssports'),
        'add_new_item'          => __('Add New Activity', 'leaderssports'),
        'edit_item'             => __('Edit Activity', 'leaderssports'),
        'new_item'              => __('New Activity', 'leaderssports'),
        'view_item'             => __('View Activity', 'leaderssports'),
        'view_items'            => __('View Activities', 'leaderssports'),
        'search_items'          => __('Search Activities', 'leaderssports'),
        'not_found'             => __('No activities found', 'leaderssports'),
        'not_found_in_trash'    => __('No activities found in Trash', 'leaderssports'),
    );

    $args = array(
        'label'                 => __('Sports Activities', 'leaderssports'),
        'description'           => __('Manage all sports activities and training programs', 'leaderssports'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail', 'excerpt', 'revisions'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-universal-access-alt',
        'show_in_rest'          => true,
        'has_archive'           => true,
        'rewrite'               => array('slug' => 'sports-activities', 'with_front' => false)
    );

    register_post_type('sports_activity', $args);
}
add_action('init', 'leaderssports_register_sports_activity_cpt');

/**
 * Register Custom Post Type: Sports Activity Registrations
 */
function leaderssports_register_sports_registration_cpt()
{
    $labels = array(
        'name'               => __('Activity Registrations', 'leaderssports'),
        'singular_name'      => __('Activity Registration', 'leaderssports'),
        'menu_name'          => __('Activity Registrations', 'leaderssports'),
        'add_new'            => __('Add New', 'leaderssports'),
        'add_new_item'       => __('Add New Registration', 'leaderssports'),
        'edit_item'          => __('Edit Registration', 'leaderssports'),
        'new_item'           => __('New Registration', 'leaderssports'),
        'all_items'          => __('All Registrations', 'leaderssports'),
        'search_items'       => __('Search Registrations', 'leaderssports'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_position'      => 21,
        'menu_icon'          => 'dashicons-clipboard',
        'supports'           => array('title', 'custom-fields'),
        'exclude_from_search' => true,
        'publicly_queryable' => false,
    );

    register_post_type('sports_registration', $args);
}
add_action('init', 'leaderssports_register_sports_registration_cpt');

add_action('add_meta_boxes', function () {
    add_meta_box(
        'sports_registration_full_info',
        __('Registration Information', 'leaderssports'),
        'leaderssports_sports_registration_box',
        'sports_registration',
        'normal',
        'high'
    );
});

function leaderssports_sports_registration_box($post)
{
    wp_nonce_field('save_sports_registration_status', 'sports_registration_nonce');

    $fields = [
        'activity_id' => __('Activity', 'leaderssports'),
        'name'        => __('Name', 'leaderssports'),
        'email'       => __('Email', 'leaderssports'),
        'phone'       => __('Phone', 'leaderssports'),
        'dob'         => __('Date of Birth', 'leaderssports'),
        'branch'      => __('Branch', 'leaderssports'),
        'level'       => __('Level', 'leaderssports'),
    ];

    echo '<table class="widefat striped">';
    foreach ($fields as $key => $label) {
        $value = get_post_meta($post->ID, $key, true);
        if ($key === 'activity_id' && $value) {
            $value = '<a href="' . get_edit_post_link($value) . '" target="_blank">' . get_the_title($value) . '</a>';
        }
        if (!$value) {
            $value = '<em>' . __('Not Provided', 'leaderssports') . '</em>';
        }
        echo '<tr><th style="width:180px;">' . $label . '</th><td>' . $value . '</td></tr>';
    }

    $status = get_post_meta($post->ID, 'status', true) ?: 'pending';

    echo '<tr><th><strong>' . __('Status', 'leaderssports') . '</strong></th><td>';
    echo '<select name="sports_registration_status" style="min-width:200px;">';
    echo '<option value="pending" ' . selected($status, 'pending', false) . '>Pending</option>';
    echo '<option value="approved" ' . selected($status, 'approved', false) . '>Approved</option>';
    echo '<option value="rejected" ' . selected($status, 'rejected', false) . '>Rejected</option>';
    echo '</select></td></tr>';
    echo '</table>';
}

add_action('save_post_sports_registration', function ($post_id) {
    if (
        !isset($_POST['sports_registration_nonce']) ||
        !wp_verify_nonce($_POST['sports_registration_nonce'], 'save_sports_registration_status')
    ) return;

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (isset($_POST['sports_registration_status'])) {
        update_post_meta($post_id, 'status', sanitize_text_field($_POST['sports_registration_status']));
    }
});

add_filter('manage_sports_registration_posts_columns', function ($columns) {
    $new = [];
    foreach ($columns as $key => $val) {
        $new[$key] = $val;
        if ($key === 'title') {
            $new['status']   = __('Status', 'leaderssports');
            $new['activity'] = __('Activity', 'leaderssports');
            $new['dob']      = __('DOB', 'leaderssports');
        }
    }
    return $new;
});

add_action('manage_sports_registration_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'status':
            $status = get_post_meta($post_id, 'status', true) ?: 'pending';
            $colors = ['approved' => '#28a745', 'rejected' => '#dc3545', 'pending' => '#ffc107'];
            echo '<span style="background:' . $colors[$status] . ';color:#fff;padding:2px 8px;border-radius:4px;">' . ucfirst($status) . '</span>';
            break;

        case 'activity':
            $id = get_post_meta($post_id, 'activity_id', true);
            echo $id ? '<a href="' . get_edit_post_link($id) . '">' . get_the_title($id) . '</a>' : '—';
            break;

        case 'dob':
            echo get_post_meta($post_id, 'dob', true) ?: '—';
            break;
    }
}, 10, 2);

add_action('restrict_manage_posts', function () {
    if (get_current_screen()->post_type !== 'sports_registration') return;
    $export_url = add_query_arg([
        'post_type'  => 'sports_registration',
        'export_csv' => 1,
        '_wpnonce'   => wp_create_nonce('export_sports_registrations'),
    ]);
    echo '<a href="' . $export_url . '" class="button button-primary" style="margin-left:10px;">Export CSV</a>';
});

add_action('admin_init', function () {
    if (
        isset($_GET['export_csv'], $_GET['_wpnonce']) &&
        wp_verify_nonce($_GET['_wpnonce'], 'export_sports_registrations')
    ) {
        $filename = 'sports-registrations-' . date('Y-m-d') . '.csv';
        header('Content-Type:text/csv; charset=utf-8');
        header('Content-Disposition:attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Name', 'Email', 'Phone', 'DOB', 'Branch', 'Level', 'Activity', 'Status', 'Date']);

        $q = new WP_Query(['post_type' => 'sports_registration', 'posts_per_page' => -1]);
        while ($q->have_posts()) {
            $q->the_post();
            $id = get_the_ID();
            fputcsv($output, [
                get_post_meta($id, 'name', true),
                get_post_meta($id, 'email', true),
                get_post_meta($id, 'phone', true),
                get_post_meta($id, 'dob', true),
                get_post_meta($id, 'branch', true),
                get_post_meta($id, 'level', true),
                get_the_title(get_post_meta($id, 'activity_id', true)),
                get_post_meta($id, 'status', true),
                get_the_date('Y-m-d H:i')
            ]);
        }
        exit;
    }
});

/**
 * AJAX: Submit Sports Registration
 */
add_action('wp_ajax_submit_sports_registration', 'leaderssports_submit_sports_registration');
add_action('wp_ajax_nopriv_submit_sports_registration', 'leaderssports_submit_sports_registration');

/**
 * AJAX: Submit Sports Activity Registration + WhatsApp
 */
function leaderssports_submit_sports_registration()
{
    if (empty($_POST['activity_id'])) {
        wp_send_json_error(['message' => __('Activity ID missing', 'leaderssports')]);
    }

    $activity_id = intval($_POST['activity_id'] ?? 0);

    $name   = sanitize_text_field($_POST['name']  ?? '');
    $email  = sanitize_email($_POST['email']      ?? '');
    $phone  = sanitize_text_field($_POST['phone'] ?? '');
    $dob    = sanitize_text_field($_POST['dob']   ?? '');
    $branch = sanitize_text_field($_POST['branch'] ?? '');
    $level  = sanitize_text_field($_POST['level']  ?? '');
    $sport  = sanitize_text_field($_POST['sport']  ?? '');

    // WhatsApp for activity (from hidden field in the form)
    $activity_whatsapp_raw = isset($_POST['activity_whatsapp'])
        ? sanitize_text_field($_POST['activity_whatsapp'])
        : '';

    // Basic validation
    if (!$name || !$email || !$phone || !$dob) {
        wp_send_json_error(['message' => __('الرجاء تعبئة جميع الحقول المطلوبة.', 'leaderssports')]);
    }

    if (!is_email($email)) {
        wp_send_json_error(['message' => __('البريد الإلكتروني غير صالح.', 'leaderssports')]);
    }

    // Create registration post
    $post_id = wp_insert_post([
        'post_type'   => 'sports_registration',
        'post_title'  => $name . ' - ' . get_the_title($activity_id),
        'post_status' => 'publish'
    ]);

    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(['message' => __('Error creating registration.', 'leaderssports')]);
    }

    // Save meta
    update_post_meta($post_id, 'activity_id', $activity_id);
    update_post_meta($post_id, 'name',        $name);
    update_post_meta($post_id, 'email',       $email);
    update_post_meta($post_id, 'phone',       $phone);
    update_post_meta($post_id, 'dob',         $dob);
    update_post_meta($post_id, 'branch',      $branch);
    update_post_meta($post_id, 'level',       $level);
    update_post_meta($post_id, 'sport',       $sport);
    update_post_meta($post_id, 'status',      'pending');

    // Optional: admin email
    $admin_email = get_option('admin_email');
    if ($admin_email) {
        $subject = 'New Sports Activity Registration: ' . get_the_title($activity_id);
        $body    = "Name: $name\nEmail: $email\nPhone: $phone\nDOB: $dob\nBranch: $branch\nSport: $sport\nLevel: $level";
        wp_mail($admin_email, $subject, $body);
    }

    // WhatsApp sending
    $customer_wa = $phone;
    $activity_wa = $activity_whatsapp_raw;

    $wa_results = [
        'activity' => null,
        'customer' => null,
    ];

    // Message to activity / coach WhatsApp
    if (!empty($activity_wa)) {
        $msg_for_activity  = "طلب تسجيل جديد في الفعالية الرياضية:\n";
        $msg_for_activity .= "الاسم: {$name}\n";
        $msg_for_activity .= "الهاتف: {$phone}\n";
        $msg_for_activity .= "البريد: {$email}\n";
        $msg_for_activity .= "تاريخ الميلاد: {$dob}\n";
        $msg_for_activity .= "الفرع: {$branch}\n";
        $msg_for_activity .= "الرياضة / النشاط: {$sport}\n";
        if (!empty($level)) {
            $msg_for_activity .= "المستوى: {$level}\n";
        }
        $msg_for_activity .= "تم الإرسال من صفحة الأنشطة الرياضية على الموقع.";

        $wa_results['activity'] = leaders_send_whatsapp_4whats($activity_wa, $msg_for_activity);
    }

    // Confirmation message to customer
    if (!empty($customer_wa)) {
        $msg_for_customer  = "شكرًا لتسجيلك في الفعالية الرياضية 🌟\n";
        $msg_for_customer .= "النشاط: {$sport}\n";
        $msg_for_customer .= "الفرع: {$branch}\n";
        if (!empty($level)) {
            $msg_for_customer .= "المستوى: {$level}\n";
        }
        $msg_for_customer .= "تاريخ الميلاد المسجَّل: {$dob}\n";
        $msg_for_customer .= "سنتواصل معك قريبًا لتأكيد التفاصيل.";

        $wa_results['customer'] = leaders_send_whatsapp_4whats($customer_wa, $msg_for_customer);
    }

    // Check WA status
    $all_wa_ok = true;
    foreach ($wa_results as $res) {
        if (is_array($res) && isset($res['success']) && $res['success'] === false) {
            $all_wa_ok = false;
            break;
        }
    }

    $message = __('تم إرسال طلب التسجيل بنجاح.', 'leaderssports');
    if (!$all_wa_ok) {
        $message .= ' ' . __('(تم حفظ الطلب لكن حدث خطأ في إرسال رسالة الواتساب، سيتم التواصل معك من قبل الإدارة.)', 'leaderssports');
    }

    wp_send_json_success([
        'message'  => $message,
        'whatsapp' => $wa_results,
    ]);
}


/**
 * Normalize phone for WhatsApp (digits-only).
 */
function leaders_normalize_phone_for_whatsapp($raw, $default_cc = '971')
{
    $digits = preg_replace('/\D+/', '', (string) $raw);

    if ($digits === '') {
        return '';
    }

    // Strip leading 00
    if (strpos($digits, '00') === 0) {
        $digits = substr($digits, 2);
    }

    // Already has country code
    if (strpos($digits, $default_cc) === 0) {
        return $digits;
    }

    // Local starting with 0
    if ($digits[0] === '0') {
        return $default_cc . substr($digits, 1);
    }

    return $digits;
}

/**
 * Send WhatsApp message via 4whats API (user.4whats.net/api/sendMessage).
 *
 * RETURN:
 *   array( 'success' => bool, 'error' => string|null, 'raw' => mixed )
 *
 * ضع هذه التعاريف في wp-config.php:
 *   define('LEADERS_4WHATS_INSTANCE_ID', '140523');
 *   define('LEADERS_4WHATS_API_KEY', 'YOUR_REAL_API_KEY');
 */
function leaders_send_whatsapp_4whats($to_number, $message_text)
{
    $instanceid = defined('LEADERS_4WHATS_INSTANCE_ID') ? LEADERS_4WHATS_INSTANCE_ID : '';
    $token      = defined('LEADERS_4WHATS_API_KEY')      ? LEADERS_4WHATS_API_KEY      : '';

    if (empty($instanceid) || empty($token)) {
        $msg = '4whats: instanceid or token not configured.';
        error_log($msg);
        return array(
            'success' => false,
            'error'   => $msg,
            'raw'     => null,
        );
    }

    $to_number    = leaders_normalize_phone_for_whatsapp($to_number);
    $message_text = trim((string) $message_text);

    if ($to_number === '' || $message_text === '') {
        $msg = '4whats: empty number or message.';
        error_log($msg);
        return array(
            'success' => false,
            'error'   => $msg,
            'raw'     => null,
        );
    }

    $endpoint = 'https://user.4whats.net/api/sendMessage';

    $query_args = array(
        'instanceid' => $instanceid,
        'token'      => $token,
        'phone'      => $to_number,
        'body'       => $message_text,
    );

    $url      = add_query_arg($query_args, $endpoint);
    $response = wp_remote_get($url, array('timeout' => 20));

    if (is_wp_error($response)) {
        $err = $response->get_error_message();
        error_log('4whats WP_Error: ' . $err);

        return array(
            'success' => false,
            'error'   => $err,
            'raw'     => null,
        );
    }

    $code = wp_remote_retrieve_response_code($response);
    $body = wp_remote_retrieve_body($response);
    $json = json_decode($body, true);

    // نعتبره ناجح لو HTTP 200-299
    $ok = ($code >= 200 && $code < 300);

    // في حال الـ API يرجّع success/status
    if (is_array($json)) {
        if (isset($json['success'])) {
            $ok = (bool) $json['success'];
        } elseif (isset($json['status']) && strtolower($json['status']) === 'success') {
            $ok = true;
        }
    }

    if (!$ok) {
        $err_msg = null;

        if (is_array($json)) {
            $err_msg = $json['message'] ?? $json['error'] ?? null;
        }
        if (!$err_msg) {
            $err_msg = '4whats HTTP ' . $code . ': ' . $body;
        }

        error_log($err_msg);

        return array(
            'success' => false,
            'error'   => $err_msg,
            'raw'     => $json ?: $body,
        );
    }

    return array(
        'success' => true,
        'error'   => null,
        'raw'     => $json ?: $body,
    );
}

/**
 * Unified AJAX handler: Academy Registration + WhatsApp
 */
function leaders_submit_academy_registration_handler()
{
    // Nonce check
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'academy_register_nonce')) {
        wp_send_json_error(array(
            'message' => 'انتهت صلاحية الجلسة، حدّث الصفحة وحاول مرة أخرى.'
        ));
    }

    // Academy ID
    $academy_id = isset($_POST['academy_id']) ? intval($_POST['academy_id']) : 0;
    if (!$academy_id) {
        wp_send_json_error(array(
            'message' => 'معرّف الأكاديمية غير موجود.'
        ));
    }

    // Sanitize input
    $name   = isset($_POST['name'])   ? sanitize_text_field(wp_unslash($_POST['name']))   : '';
    $email  = isset($_POST['email'])  ? sanitize_email(wp_unslash($_POST['email']))       : '';
    $phone  = isset($_POST['phone'])  ? sanitize_text_field(wp_unslash($_POST['phone']))  : '';
    $dob    = isset($_POST['dob'])    ? sanitize_text_field(wp_unslash($_POST['dob']))    : '';
    $branch = isset($_POST['branch']) ? sanitize_text_field(wp_unslash($_POST['branch'])) : '';
    $sport  = isset($_POST['sport'])  ? sanitize_text_field(wp_unslash($_POST['sport']))  : '';
    $academy_whatsapp_raw = isset($_POST['academy_whatsapp']) ? wp_unslash($_POST['academy_whatsapp']) : '';

    if ($name === '' || $email === '' || $phone === '' || $dob === '') {
        wp_send_json_error(array(
            'message' => 'الرجاء تعبئة جميع الحقول المطلوبة.'
        ));
    }

    if (!is_email($email)) {
        wp_send_json_error(array(
            'message' => 'البريد الإلكتروني غير صالح.'
        ));
    }

    // إنشاء سجل التسجيل في الأكاديمية
    $post_id = wp_insert_post(array(
        'post_type'   => 'academy_registration',
        'post_title'  => $name . ' - ' . get_the_title($academy_id),
        'post_status' => 'publish',
    ));

    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(array(
            'message' => __('Error creating registration.', 'leaderssports'),
        ));
    }

    // حفظ الميتا
    update_post_meta($post_id, 'academy_id', $academy_id);
    update_post_meta($post_id, 'name', $name);
    update_post_meta($post_id, 'email', $email);
    update_post_meta($post_id, 'phone', $phone);
    update_post_meta($post_id, 'dob', $dob);
    update_post_meta($post_id, 'branch', $branch);
    update_post_meta($post_id, 'sport', $sport);
    update_post_meta($post_id, 'status', 'pending');

    // إرسال إيميل للأدمن (اختياري)
    $admin_email = get_option('admin_email');
    if ($admin_email) {
        $subject = 'New Academy Registration: ' . get_the_title($academy_id);
        $body    = "Name: $name\nEmail: $email\nPhone: $phone\nDOB: $dob\nBranch: $branch\nSport: $sport";
        wp_mail($admin_email, $subject, $body);
    }

    // إعداد أرقام الواتساب
    $customer_wa = $phone;
    $academy_wa  = $academy_whatsapp_raw;

    $wa_results = array(
        'academy'  => null,
        'customer' => null,
    );

    // رسالة للأكاديمية (تتضمن تاريخ الميلاد)
    if (!empty($academy_wa)) {
        $msg_for_academy  = "طلب تسجيل جديد في الأكاديمية:\n";
        $msg_for_academy .= "الاسم: {$name}\n";
        $msg_for_academy .= "الهاتف: {$phone}\n";
        $msg_for_academy .= "البريد: {$email}\n";
        $msg_for_academy .= "تاريخ الميلاد: {$dob}\n";
        $msg_for_academy .= "الفرع: {$branch}\n";
        $msg_for_academy .= "الرياضة: {$sport}\n";
        $msg_for_academy .= "تم الإرسال من موقع الأكاديمية.";

        $wa_results['academy'] = leaders_send_whatsapp_4whats($academy_wa, $msg_for_academy);
    }

    // رسالة تأكيد للعميل
    if (!empty($customer_wa)) {
        $msg_for_customer  = "شكرًا لتسجيلك في الأكاديمية 🌟\n";
        $msg_for_customer .= "الفرع: {$branch}\n";
        $msg_for_customer .= "الرياضة: {$sport}\n";
        $msg_for_customer .= "تاريخ الميلاد المسجَّل: {$dob}\n";
        $msg_for_customer .= "سنتواصل معك قريبًا لتأكيد موعد التجربة.";

        $wa_results['customer'] = leaders_send_whatsapp_4whats($customer_wa, $msg_for_customer);
    }

    // نحدد هل كل رسائل الواتساب نجحت أم لا
    $all_wa_ok = true;
    foreach ($wa_results as $res) {
        if (is_array($res) && $res['success'] === false) {
            $all_wa_ok = false;
            break;
        }
    }

    $message = 'تم إرسال طلب التسجيل بنجاح.';
    if (!$all_wa_ok) {
        $message .= ' (تم حفظ الطلب لكن حدث خطأ في إرسال رسالة الواتساب، سيتم التواصل معك من قبل الإدارة.)';
    }

    wp_send_json_success(array(
        'message'  => $message,
        'whatsapp' => $wa_results,
    ));
}

add_action('wp_ajax_submit_academy_registration',        'leaders_submit_academy_registration_handler');
add_action('wp_ajax_nopriv_submit_academy_registration', 'leaders_submit_academy_registration_handler');
