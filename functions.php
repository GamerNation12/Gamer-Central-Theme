<?php
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '2.0' );
}

function gamer_central_setup() {
    add_theme_support( 'automatic-feed-links' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    register_nav_menus(
        array(
            'menu-1' => esc_html__( 'Primary', 'gamer-central' ),
        )
    );

    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    add_theme_support( 'customize-selective-refresh-widgets' );
    add_theme_support( 'custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-width'  => true,
        'flex-height' => true,
    ) );
}
add_action( 'after_setup_theme', 'gamer_central_setup' );

function gamer_central_widgets_init() {
    register_sidebar(
        array(
            'name'          => esc_html__( 'Sidebar', 'gamer-central' ),
            'id'            => 'sidebar-1',
            'description'   => esc_html__( 'Add widgets here.', 'gamer-central' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h2 class="widget-title" style="font-size:18px; margin-top:0; margin-bottom:15px; color:#ffffff;">',
            'after_title'   => '</h2>',
        )
    );
}
add_action( 'widgets_init', 'gamer_central_widgets_init' );

function gamer_central_scripts() {
    wp_enqueue_style( 'gamer-central-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'gamer_central_scripts' );
