<div id="sidebar">
	

<a href="<?php echo esc_url( home_url()); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/logo.jpg" alt="logo"></a>
<?php if ( !function_exists('dynamic_sidebar')
|| !dynamic_sidebar()): ?>

<?php endif; ?>

</div>