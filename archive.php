<?php get_header(); ?>
    <?php rp_get_cat_banner() ?>
    <div id="main-content">
        <div class="container static-page-content">
            <div class="row">
                <?php get_sidebar(); ?>
                <div class="col-xs-9">
                    <section class="sp-wrapper">
                        <div class="news-post-list">
                            <?php while (have_posts()):the_post(); ?>
                            <article>
                                <header>
                                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title()?>"><?php the_title()?></a></h3>
                                </header>
                                <?php the_post_thumbnail("blogImage"); ?>
                                <div class="news-content">
                                    <?php the_excerpt(); ?>
                                </div>
                                <footer>
                                    <div class="row">
                                        <div class="col-xs-9">
                                            Categories: <?php the_category(' ') ?>
                                        </div>
                                        <div class="col-xs-3">
                                            <p class="news-date"><?php echo get_the_date(); ?></p>
                                        </div>
                                    </div>
                                </footer>
                            </article>
                            <?php endwhile ;?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
