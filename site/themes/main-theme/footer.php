</main><!-- /#main -->

<footer id="site-footer" class="site-footer" role="contentinfo">
	<div class="container">

		<!-- TOP AREA -->
		<div class="footer-top row align-items-center">

			<!-- LOGO -->
			<div class="footer-brand col-12 col-md-4 mb-3 mb-md-0 text-center text-md-start">
				<a href="<?php echo esc_url(home_url('/')); ?>" class="footer-logo" aria-label="<?php bloginfo('name'); ?>">
					<?php
					$footer_logo = get_theme_mod('footer_logo') ?: get_theme_mod('header_logo');
					if ($footer_logo): ?>
						<img src="<?php echo esc_url($footer_logo); ?>" alt="<?php bloginfo('name'); ?>">
					<?php else: ?>
						<span class="footer-site-name"><?php bloginfo('name'); ?></span>
					<?php endif; ?>
				</a>
			</div>

			<!-- MENU -->
			<div class="footer-nav col-12 col-md-8">
				<?php
				$loc = has_nav_menu('main-menu') ? 'main-menu' : '';
				if ($loc):
					wp_nav_menu([
						'theme_location' => $loc,
						'container'      => 'nav',
						'container_class' => 'footer-menu-container',
						'menu_class'     => 'footer-menu nav justify-content-md-end justify-content-center',
						'depth'          => 1,
					]);
				endif;
				?>
			</div>

		</div><!-- /top -->

		<!-- WIDGETS -->
		<?php if (is_active_sidebar('third_widget_area')): ?>
			<div class="footer-widgets row mt-4">
				<div class="col-12">
					<?php dynamic_sidebar('third_widget_area'); ?>
				</div>
			</div>
		<?php endif; ?>

		<!-- BOTTOM AREA -->
		<div class="footer-bottom row align-items-center mt-4 pt-3">

			<div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
				<p class="footer-copy mb-0">
					© <?php echo date_i18n('Y'); ?> <?php bloginfo('name'); ?> — جميع الحقوق محفوظة
				</p>
			</div>

			<div class="col-12 col-md-6 text-center text-md-end">
				<?php if (has_nav_menu('legal-menu')):
					wp_nav_menu([
						'theme_location' => 'legal-menu',
						'container'      => 'nav',
						'container_class' => 'footer-legal-container',
						'menu_class'     => 'footer-legal nav justify-content-center justify-content-md-end',
						'depth'          => 1,
					]);
				endif; ?>
			</div>

		</div><!-- /bottom -->

	</div>
</footer>

</div><!-- /#wrapper -->
<script>
	document.addEventListener("DOMContentLoaded", () => {
		// Give a little time for the effect (1.5–2 sec)
		setTimeout(() => {
			document.getElementById('ls-preloader').classList.add('hide');
		}, 1500);
	});
</script>
<?php wp_footer(); ?>
</body>

</html>