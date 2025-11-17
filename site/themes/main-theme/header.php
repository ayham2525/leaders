<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <?php wp_head(); ?>
</head>

<?php
$navbar_scheme   = get_theme_mod('navbar_scheme', ''); // Get custom meta-value.
$navbar_position = get_theme_mod('navbar_position', 'static'); // Get custom meta-value.

$search_enabled  = get_theme_mod('search_enabled', '1'); // Get custom meta-value.
?>

<body <?php body_class(); ?>>
  <div id="ls-preloader">
    <img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/logo.jpg" alt="Loading">
  </div>

  <?php wp_body_open(); ?>

  <a href="#main" class="visually-hidden-focusable"><?php esc_html_e('Skip to main content', 'wp_bootstrap_starter'); ?></a>

  <div id="wrapper">
    <header>
      <nav id="header" class="navbar navbar-expand-md <?php echo esc_attr($navbar_scheme);
                                                      if ($navbar_position === 'fixed_top')  echo ' fixed-top';
                                                      if ($navbar_position === 'fixed_bottom') echo ' fixed-bottom';
                                                      if (is_home() || is_front_page()) echo ' home'; ?>">
        <div class="container-fluid">

          <!-- Open menu button (hamburger) -->
          <button id="openMenuBtn"
            class="menu-toggle"
            aria-controls="offcanvasMenu"
            aria-expanded="false"
            aria-label="<?php esc_attr_e('Open menu', 'wp_bootstrap_starter'); ?>">
            <!-- Hamburger SVG -->
            <svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
              <path fill="currentColor" d="M3 6h18v2H3V6zm0 5h18v2H3v-2zm0 5h18v2H3v-2z" />
            </svg>
          </button>

          <a class="navbar-brand" href="<?php echo esc_url(home_url()); ?>">
            <?php if ($header_logo = get_theme_mod('header_logo')): ?>
              <img src="<?php echo esc_url($header_logo); ?>" alt="<?php bloginfo('name'); ?>" />
            <?php else: echo esc_html(get_bloginfo('name', 'display'));
            endif; ?>
          </a>

          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDummy" aria-label="<?php esc_attr_e('Toggle navigation', 'wp_bootstrap_starter'); ?>">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav>
    </header>

    <!-- Overlay (click to close) -->
    <div id="menuOverlay" class="offcanvas-overlay" hidden></div>

    <!-- Off-canvas menu (default closed) -->
    <aside id="offcanvasMenu"
      class="offcanvas-menu"
      role="dialog"
      aria-modal="true"
      aria-hidden="true">
      <button id="closeMenuBtn"
        class="menu-close"
        aria-label="<?php esc_attr_e('Close menu', 'wp_bootstrap_starter'); ?>">
        <!-- Close SVG -->
        <svg width="28" height="28" viewBox="0 0 24 24" aria-hidden="true">
          <path fill="currentColor" d="M18.3 5.71 12 12l6.3 6.29-1.41 1.42L10.59 13.4 4.3 19.71 2.89 18.3 9.17 12 2.89 5.71 4.3 4.29 10.59 10.6l6.3-6.31z" />
        </svg>
      </button>

      <?php
      wp_nav_menu([
        'theme_location' => 'main-menu',
        'container'      => '',
        'menu_class'     => 'side-nav',
        'fallback_cb'    => 'WP_Bootstrap_Navwalker::fallback',
        'walker'         => new WP_Bootstrap_Navwalker(),
      ]);
      ?>
    </aside>


    <!-- Floating quick links -->
    <div class="floating-quicklinks">
      <a href="https://wa.me/971500000000" target="_blank" rel="noopener" aria-label="WhatsApp">
        <!-- WhatsApp SVG -->
        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path fill="currentColor" d="M20.52 3.48A11.94 11.94 0 0 0 12.01 0C5.4.01.01 5.4 0 12c0 2.11.55 4.17 1.6 5.99L0 24l6.17-1.61A11.96 11.96 0 0 0 24 12c0-3.19-1.24-6.19-3.48-8.52zM12 22a9.96 9.96 0 0 1-5.09-1.4l-.36-.21-3.63.95.97-3.54-.24-.37A10.01 10.01 0 1 1 22 12c0 5.52-4.48 10-10 10zm5.36-7.64c-.29-.15-1.73-.85-2-.94-.27-.1-.47-.15-.67.15-.2.29-.77.94-.95 1.13-.18.2-.35.22-.64.08-.29-.15-1.23-.45-2.35-1.44-.87-.77-1.46-1.72-1.63-2-.17-.29-.02-.45.13-.6.13-.13.29-.35.44-.52.15-.17.2-.29.29-.49.1-.2.05-.37-.02-.52-.08-.15-.67-1.62-.92-2.22-.24-.58-.49-.5-.67-.5h-.57c-.2 0-.52.07-.79.37-.27.29-1.04 1.02-1.04 2.49 0 1.47 1.07 2.89 1.22 3.09.15.2 2.11 3.22 5.11 4.52.72.31 1.29.5 1.73.64.73.23 1.4.2 1.93.12.59-.09 1.73-.71 1.98-1.4.24-.69.24-1.28.17-1.4-.06-.12-.24-.2-.53-.35z" />
        </svg>
      </a>

      <a href="tel:+971500000000" aria-label="Call us">
        <!-- Phone SVG -->
        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path fill="currentColor" d="M6.62 10.79a15.053 15.053 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.02-.24c1.12.37 2.33.57 3.57.57a1 1 0 0 1 1 1V21a1 1 0 0 1-1 1C10.85 22 2 13.15 2 2a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.24.2 2.45.57 3.57a1 1 0 0 1-.25 1.02l-2.2 2.2z" />
        </svg>
      </a>

      <a href="mailto:info@example.com" aria-label="Email us">
        <!-- Mail SVG -->
        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path fill="currentColor" d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 4-8 5L4 8V6l8 5 8-5v2z" />
        </svg>
      </a>

      <a href="https://instagram.com/yourprofile" target="_blank" rel="noopener" aria-label="Instagram">
        <!-- Instagram SVG -->
        <svg viewBox="0 0 24 24" width="22" height="22" aria-hidden="true">
          <path fill="currentColor" d="M7 2C4.243 2 2 4.243 2 7v10c0 2.757 2.243 5 5 5h10c2.757 0 5-2.243 5-5V7c0-2.757-2.243-5-5-5H7zm10 2c1.654 0 3 1.346 3 3v10c0 1.654-1.346 3-3 3H7c-1.654 0-3-1.346-3-3V7c0-1.654 1.346-3 3-3h10zm-5 3a5 5 0 1 0 .001 10.001A5 5 0 0 0 12 7zm0 2a3 3 0 1 1-.001 6.001A3 3 0 0 1 12 9zm4.5-3a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
        </svg>
      </a>
    </div>


    <main id="main" class="container-fluid p-0" <?php if (isset($navbar_position) && 'fixed_top' === $navbar_position) : echo ' style="padding-top: 100px;"';
                                                elseif (isset($navbar_position) && 'fixed_bottom' === $navbar_position) : echo ' style="padding-bottom: 100px;"';
                                                endif; ?>>


      <script>
        window.addEventListener("scroll", function() {
          const header = document.querySelector("header");
          if (window.scrollY > 50) {
            header.classList.add("scrolled");
          } else {
            header.classList.remove("scrolled");
          }
        });
      </script>