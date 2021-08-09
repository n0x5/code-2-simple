<?php

function valens_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Widget Area', 'valens' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'valens' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'valens_widgets_init' );


function register_my_menus() {
  register_nav_menus(
    array('header-menu' => __( 'Header Menu 1', 'valens' ) )
  );
}


add_filter( 'image_strip_meta', function() {
 return true;
});

add_theme_support( 'title-tag' );

add_theme_support( 'automatic-feed-links' );
add_theme_support( 'custom-background' );
add_theme_support( 'custom-header' );


add_theme_support( 'post-thumbnails' );

$markup = array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'html5' );
add_theme_support( $markup );   

function data_scripts() {
wp_enqueue_style( 'data-style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'data_scripts' );


?>