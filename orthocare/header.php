<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package orthocare
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Meta Tags for SEO -->
    <title>OrthoCare WP – WordPress Theme for Orthopaedic Doctors & Medical Clinics</title>
    <meta name="description" content="A modern WordPress theme for orthopaedic doctors, clinics, and hospitals — built with Elementor and Bootstrap for responsive, SEO-friendly medical websites.">
    <link rel="canonical" href="https://themixly.com/preview/2248/orthocare-wp-wordpress-theme-for-orthopaedic-doctors-clinics-hospitals/">
    <meta name="author" content="OrthoCare WP">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="OrthoCare WP">
    <meta property="og:title" content="OrthoCare WP – WordPress Theme for Orthopaedic Doctors & Medical Clinics">
    <meta property="og:description" content="A modern WordPress theme for orthopaedic doctors, clinics, and hospitals — built with Elementor and Bootstrap for responsive, SEO-friendly medical websites.">
    <meta property="og:url" content="https://themixly.com/preview/2248/orthocare-wp-wordpress-theme-for-orthopaedic-doctors-clinics-hospitals/">
    <meta property="og:image" content="https://themixly.com/wp-content/uploads/2025/06/OrthoCare-Product-Detail-Image-1-scaled.png">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="OrthoCare WP – WordPress Theme for Orthopaedic Doctors & Medical Clinics">
    <meta name="twitter:description" content="A modern WordPress theme for orthopaedic doctors, clinics, and hospitals — built with Elementor and Bootstrap for responsive, SEO-friendly medical websites.">
    <meta name="twitter:url" content="https://themixly.com/preview/2248/orthocare-wp-wordpress-theme-for-orthopaedic-doctors-clinics-hospitals/">
    <meta name="twitter:image" content="https://themixly.com/wp-content/uploads/2025/06/OrthoCare-Product-Detail-Image-1-scaled.png">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'orthocare' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="site-branding">
			<?php
			the_custom_logo();
			if ( is_front_page() && is_home() ) :
				?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php
			else :
				?>
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
			endif;
			$orthocare_description = get_bloginfo( 'description', 'display' );
			if ( $orthocare_description || is_customize_preview() ) :
				?>
				<p class="site-description"><?php echo $orthocare_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
			<?php endif; ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'orthocare' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'menu-1',
					'menu_id'        => 'primary-menu',
				)
			);
			?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->
