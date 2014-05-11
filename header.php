<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php wp_title(''); ?></title>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>

</head>
<body <?php body_class(); ?>>
<div id="main">
    <header id="header">
        <div class="wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-xs-4">
                        <h1><a href="/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/site/logo.png" alt="<?php _e("Some Company Name","rp_test"); ?>" title="<?php _e("Some Company Name","rp_test"); ?>" height="53" width="250" /></a></h1>
                    </div>
                    <div class="col-xs-8">
                        <?php rp_get_nav_menu('top-nav','nav','main-menu') ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
