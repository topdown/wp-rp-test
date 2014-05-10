            <footer id="footer">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-5">
                            <div class="logo">
                                <h1><a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/site/logo-small.png" alt="Some Company Name" title="Some Company Name" height="35" width="195" /></a></h1>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <?php rp_footer_socials(); ?>
                        </div>
                        <div class="col-xs-5">
                            <div class="copyright">
                                <p>
                                    <?php echo get_option('rp_copyright_1'); ?>
                                    <span><?php echo get_option('rp_copyright_2'); ?></span>
                                    <?php echo get_option('rp_copyright_3'); ?>
                                </p>
                                <?php rp_get_nav_menu('footer-nav',false,'','footer-info-menu') ?>

                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <?php wp_footer() ?>
    </body>
</html>