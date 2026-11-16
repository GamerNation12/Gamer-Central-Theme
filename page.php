<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <h1 class="entry-title" style="margin-top: 0; margin-bottom: 20px; font-size: 28px; font-weight: 800;"><?php the_title(); ?></h1>
                </header>
                <div class="entry-content">
                    <?php
                    the_content();
                    
                    wp_link_pages(
                        array(
                            'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'gamer-central' ),
                            'after'  => '</div>',
                        )
                    );
                    ?>
                </div>
            </article>
            <?php
        endwhile;
        ?>
    </main>
</div>

<?php
get_sidebar();
get_footer();
