<?php
/**
 * Template Name: Struktur Organisasi
 * Template Post Type: page
 *
 * @package WebJTI_Theme
 * @since 1.0.0
 */

get_header();

?>

<main id="primary" class="site-main organizational-structure-page">

    <?php
    /*
    ==================================================
    PAGE HEADER
    ==================================================
    */
    get_template_part(
        'template-parts/components/page-header'
    );
    ?>

    <div class="container">

        <div class="page-layout with-sidebar">

            <?php
            /*
            ==================================================
            SIDEBAR NAVIGATION
            ==================================================
            */
            get_template_part(
                'template-parts/components/sidebar/sidebar'
            );
            ?>

            <div class="page-content documentation-content">

                <?php
                /*
                ==================================================
                ORGANIZATIONAL STRUCTURE SECTION
                ==================================================
                */
                while (have_posts()) :
                    the_post();
                    get_template_part(
                        'template-parts/components/content-block',
                        null,
                        [
                            'title'   => get_the_title(),
                            'icon'    => 'ph-squares-four',
                            'content' => apply_filters('the_content', get_the_content()),
                        ]
                    );
                endwhile;
                ?>

            </div><!-- .page-content -->

        </div><!-- .page-layout -->

    </div><!-- .container -->

</main><!-- #primary -->

<?php

get_footer();