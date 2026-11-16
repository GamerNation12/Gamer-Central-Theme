<?php
if ( ! defined( '_S_VERSION' ) ) {
    define( '_S_VERSION', '2.5' );
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
    $sharing_image = get_theme_file_uri( '/assets/logo.png' );
    $fallback_image = get_theme_file_uri( '/screenshot.png' );

    $is_home = is_front_page() && is_home();

    $title = $site_name;
    $desc = $is_home ? $site_name : $description;
    $type = 'website';
    $url = home_url( '/' );
    $img = $fallback_image;
    $img_width = 1200;
    $img_height = 630;

    if ( $is_home ) {
        $desc = esc_html( $description );
    } elseif ( is_singular() && $post ) {
        $title = get_the_title( $post );
        $desc = get_the_excerpt( $post ) ?: $description;
        $type = 'article';
        $url = get_permalink( $post );
        if ( has_post_thumbnail( $post ) ) {
            $img = get_the_post_thumbnail_url( $post, 'large' );
        } else {
            $img = $sharing_image;
        }
        $published = get_the_time( 'c', $post );
        $modified = get_the_modified_time( 'c', $post );
        $author = get_the_author_meta( 'display_name', $post->post_author );
        $categories = wp_get_post_categories( $post->ID );
        $category = $categories ? get_cat_name( $categories[0] ) : '';
        $tags = wp_get_post_tags( $post->ID );
        $tag_list = array();
        foreach ( $tags as $tag ) {
            $tag_list[] = $tag->name;
        }
    }
    ?>
    <meta name="description" content="<?php echo esc_attr( $desc ); ?>">
    <meta name="robots" content="index, follow">
    <meta name="theme-color" content="#090d16">
    <meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
    <meta property="og:description" content="<?php echo esc_attr( $desc ); ?>">
    <meta property="og:type" content="<?php echo esc_attr( $type ); ?>">
    <meta property="og:url" content="<?php echo esc_url( $url ); ?>">
    <?php if ( ! $is_home ) : ?>
    <meta property="og:image" content="<?php echo esc_url( $img ); ?>">
    <meta property="og:image:width" content="<?php echo esc_attr( $img_width ); ?>">
    <meta property="og:image:height" content="<?php echo esc_attr( $img_height ); ?>">
    <meta property="og:image:alt" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="<?php echo esc_url( $img ); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr( $title ); ?>">
    <?php else : ?>
    <meta property="og:image" content="<?php echo esc_url( $sharing_image ); ?>">
    <meta property="og:image:width" content="512">
    <meta property="og:image:height" content="512">
    <meta property="og:image:alt" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:image" content="<?php echo esc_url( $sharing_image ); ?>">
    <meta name="twitter:image:alt" content="<?php echo esc_attr( $title ); ?>">
    <?php endif; ?>
    <meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
    <meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
    <meta name="twitter:description" content="<?php echo esc_attr( $desc ); ?>">
    <link rel="canonical" href="<?php echo esc_url( $url ); ?>">
    <?php if ( ! empty( $author ) ) : ?>
    <meta property="article:author" content="<?php echo esc_attr( $author ); ?>">
    <?php endif; ?>
    <?php if ( ! empty( $category ) ) : ?>
    <meta property="article:section" content="<?php echo esc_attr( $category ); ?>">
    <?php endif; ?>
    <?php if ( ! empty( $tag_list ) ) : ?>
    <?php foreach ( $tag_list as $tag ) : ?>
    <meta property="article:tag" content="<?php echo esc_attr( $tag ); ?>">
    <?php endforeach; ?>
    <?php endif; ?>
    <?php if ( ! empty( $published ) ) : ?>
    <meta property="article:published_time" content="<?php echo esc_attr( $published ); ?>">
    <?php endif; ?>
    <?php if ( ! empty( $modified ) ) : ?>
    <meta property="article:modified_time" content="<?php echo esc_attr( $modified ); ?>">
    <?php endif; ?>
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
