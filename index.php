<?php
get_header();
?>
<div id="primary" class="content-area">
    <main id="main" class="site-main">
        <?php
        if ( have_posts() ) :
            while ( have_posts() ) :
                the_post();
                ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                    <header class="entry-header">
                        <?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" style="text-decoration:none; color:inherit;">', '</a></h2>' ); ?>
                    </header>
                    <div class="entry-content">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail('large', array('style' => 'width:100%; height:auto; border-radius:10px; margin-bottom:15px;'));
                        }
                        the_excerpt();
                        ?>
                    </div>
                </article>
                <?php
            endwhile;
            the_posts_navigation();
        else :
            ?>
            <p><?php esc_html_e( 'No posts found.', 'gamer-central' ); ?></p>
            <?php
        endif;
        ?>
    </main>
</div>
<?php
get_sidebar();
get_footer();
