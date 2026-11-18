<?php
?>
    <footer id="colophon" class="site-footer">
        <div class="site-info">
            &copy; <?php echo date('Y'); ?> Gamer Central. All rights reserved. 
            <span class="sep"> | </span>
            Gamer Central Theme by GamerNation12.
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
<script>
if (window.location.search.includes('doing_wp_cron')) {
    const url = new URL(window.location.href);
    url.searchParams.delete('doing_wp_cron');
    window.history.replaceState({}, document.title, url.toString());
}
</script>
</body>
</html>
