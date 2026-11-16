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

/* --- Built-in GitHub Branch Updater (No Plugins, No Tags Required) --- */
class Gamer_Central_GitHub_Branch_Updater {
    private $theme_slug = 'gamer-central';
    private $username   = 'GamerNation12';
    private $repository = 'Gamer-Central-Theme';
    private $branch     = 'main';

    public function __construct() {
        add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_update' ) );
        add_filter( 'upgrader_source_selection', array( $this, 'source_selection' ), 10, 3 );
    }

    public function check_update( $transient ) {
        if ( empty( $transient->checked ) || ! isset( $transient->checked[ $this->theme_slug ] ) ) {
            return $transient;
        }

        $current_version = $transient->checked[ $this->theme_slug ];
        $raw_url = "https://raw.githubusercontent.com/{$this->username}/{$this->repository}/{$this->branch}/style.css";
        
        $response = wp_remote_get( $raw_url, array( 'sslverify' => false, 'timeout' => 5 ) );
        if ( is_wp_error( $response ) ) {
            return $transient;
        }

        $style_css = wp_remote_retrieve_body( $response );
        if ( preg_match( '/^[ 	\/*#@]*Version:\s*(.*)$/mi', $style_css, $match ) ) {
            $remote_version = trim( $match[1] );

            if ( version_compare( $remote_version, $current_version, '>' ) ) {
                $transient->response[ $this->theme_slug ] = array(
                    'theme'       => $this->theme_slug,
                    'new_version' => $remote_version,
                    'url'         => "https://github.com/{$this->username}/{$this->repository}",
                    'package'     => "https://github.com/{$this->username}/{$this->repository}/archive/refs/heads/{$this->branch}.zip",
                );
            }
        }

        return $transient;
    }

    public function source_selection( $source, $remote_source, $upgrader ) {
        global $wp_filesystem;
        $target_dir = trailingslashit( $remote_source ) . $this->theme_slug . '/';
        if ( strpos( $source, 'Gamer-Central-Theme' ) !== false && $source !== $target_dir ) {
            if ( $wp_filesystem->move( $source, $target_dir ) ) {
                return $target_dir;
            }
        }
        return $source;
    }
}
new Gamer_Central_GitHub_Branch_Updater();
