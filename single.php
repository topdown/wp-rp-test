<?php get_header(); ?>
    <div class="page-banner">
        <div class="page-banner-image">
            <div class="image-cover"></div>
            <?php rp_get_banner_image(400); ?>
        </div>
        <div class="page-banner-content">
            <div class="container">
                <div class="pbc-box">
                    <h2><?php rp_get_banner_heading("banner_custom_title"); ?></h2>
                    <?php the_field('banner_description'); ?>
                </div>
            </div>
        </div>
    </div>
    <div id="main-content">
        <div class="container static-page-content">
            <div class="row">
                <?php get_sidebar() ?>
                <div class="col-xs-9">
                    <section class="sp-wrapper">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <article class="news-single-post">
                                <header class="sp-headline">
                                    <h3><?php the_title(); ?></h3>
                                </header>
                                <?php the_post_thumbnail("blogImage"); ?>
                                <div class="news-content">
                                <?php the_content(); ?>
                                </div>
                            </article>
                        <?php endwhile; ?>
                    </section>
                </div>
            </div>
        </div>
    </div>

<?php get_footer(); ?>
