<?php
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '2.2' );
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

function gamer_central_seo() {
    global $post;
    $site_name = get_bloginfo( 'name' );
    $description = get_bloginfo( 'description' );
    $image = get_theme_file_uri( '/screenshot.png' );

    $title = $site_name;
    $desc = $description;
    $type = 'website';
    $url = home_url( '/' );
    $img = $image;

    if ( is_singular() && $post ) {
        $title = get_the_title( $post );
        $desc = get_the_excerpt( $post ) ?: $description;
        $type = 'article';
        $url = get_permalink( $post );
        if ( has_post_thumbnail( $post ) ) {
            $img = get_the_post_thumbnail_url( $post, 'large' );
        }
    }
    ?>
    <meta name="description" content="<?php echo esc_attr( $desc ); ?>">
    <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $desc ); ?>">
    <meta property="og:type" content="<?php echo esc_attr( $type ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $url ); ?>">
    <meta property="og:image" content="<?php echo esc_url( $img ); ?>">
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $desc ); ?>">
    <meta name="twitter:image" content="<?php echo esc_url( $img ); ?>">
    <link rel="canonical" href="<?php echo esc_url( $url ); ?>">
    <?php
}
add_action( 'wp_head', 'gamer_central_seo' );

function gamer_central_schema() {
    ?>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "name": "<?php echo esc_js( get_bloginfo( 'name' ) ); ?>",
        "url": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "description": "<?php echo esc_js( get_bloginfo( 'description' ) ); ?>"
    }
    </script>
    <?php
}
add_action( 'wp_head', 'gamer_central_schema' );
