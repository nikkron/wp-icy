<?php 
/**
 * The Header for the theme.
 * 
 * @author WildWebLab
 * @link   http://wildweblab.com/theme/icy
 */
?><!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php do_action( 'wwl_before_wrap' ); // Hook ?>
<?php echo apply_filters( 'wwl_wrap_tag', '<div id="wrap">' ); ?>
	<?php do_action( 'wwl_before_header' ); // Hook ?>
	<header id="header" role="banner">	
			<?php do_action( 'wwl_header' ); // Hook ?>	
	</header>
	<?php do_action( 'wwl_after_header' ); // Hook ?>
	<?php do_action( 'wwl_before_main' ); // Hook ?>
	<div id="main" class="container">
		<?php do_action( 'wwl_open_main' ); // Hook ?>
			<div id="content-sidebar-wrap">
				<?php do_action( 'wwl_before_content' ); // Hook ?>
				<div id="content">
					<?php do_action( 'wwl_open_content' ); // Hook ?>