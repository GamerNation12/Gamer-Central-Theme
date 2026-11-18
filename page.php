<?php
/**
 * The template for displaying all pages
 */

get_header();
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if ( is_front_page() ) :
            ?>
            <section class="home-welcome">
                <h1 class="home-title">Welcome to Gamer Central</h1>
                <p class="home-lead">Your destination for gaming news, reviews, videos, and community discussion.</p>
            </section>
        <?php endif; ?>

        <?php while ( have_posts() ) :
            the_post();
            ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                    <?php if ( ! is_front_page() ) : ?>
                        <h1 class="entry-title" style="margin-top: 0; margin-bottom: 20px; font-size: 28px; font-weight: 800; color: #f3f4f6;"><?php the_title(); ?></h1>
                    <?php endif; ?>
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
