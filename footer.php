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
    const cleanUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.replaceState({}, document.title, cleanUrl);
}
</script>
</body>
</html>
