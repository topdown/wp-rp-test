<?php get_header();?>
    <div id="main-content">
        <div class="container static-page-content">
            <div class="row">
                <?php get_sidebar(); ?>
                <div class="col-xs-9">
                    <section class="sp-wrapper">
                        <header class="sp-headline">
                            <h3>
                                <?php if( function_exists("get_field") ){
                                    the_field("page_headline");
                                } else {
                                    the_title();
                                }?>
                            </h3>
                        </header>
                        <div class="sp-content">
                            <?php while(have_posts()) {
                                the_post_thumbnail("blogImage");
                                the_post();
                                the_content();
                            } ?>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
<?php get_footer(); ?>
