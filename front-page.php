<?php get_header(); ?>

    <div class="landing-banner">
        <div class="landing-banner-image">
            <div class="image-cover"></div>
            <?php rp_get_banner_image(); ?>
        </div>
        <div class="landing-banner-content">
            <div class="container">
                <div class="lbc-box">
                    <?php rp_get_home_banner_heading(); ?>
                    <?php the_field('banner_description'); ?>
                    <?php rp_get_home_banner_button('base-button bb-small bordered-button'); ?>
                </div>
            </div>
        </div>
    </div>

    <div id="main-content">
        <div class="landing">

            <section class="content-section">
                <div class="container">
                    <?php rp_get_about_section("cs-headline"); ?>
                </div>
            </section>

            <section class="content-section services-section">
                <div class="container">
                    <?php rp_get_service_section(); ?>
                </div>
            </section>

            <section class="content-section news-section">
                <div class="container">
                    <?php rp_get_news_section(); ?>
                </div>
            </section>

            <section class="content-section contacts-section">
                <div class="container">
                   <?php rp_get_contacts_section(); ?>
                </div>
            </section>

        </div>
    </div>
<?php get_footer(); ?>