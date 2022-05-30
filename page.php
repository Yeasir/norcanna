<?php
/* Template Name: Our Mission Page */

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package norcanna
 */
get_header('pages');

$continer = 'container';
$myaccountArea = 'common-content';

if ( class_exists( 'WooCommerce' ) ) {
    if( is_account_page() ){
        $continer = 'container-fluid';
        $myaccountArea = ' myacount-area';
    }
}

?>
    <!-- /.main start  -->
    <main class="main">
        <section class="about-content <?php echo $myaccountArea; ?>">
            <div class="<?php echo $continer; ?>">
                <div class="row">
                    <?php
                    global $post;
                    $current_page_slug = $post->post_name;
                    $slug = $post->post_name;

                    if ($post->post_parent) {
                        $ancestors = get_post_ancestors($post->ID);
                        $parent = $ancestors[count($ancestors) - 1];
                    } else {
                        $parent = $post->ID;
                    }
                    $args = array(
                        'post_type' => 'page', //write slug of post type
                        'posts_per_page' => -1,
                        'post_parent' => $parent, //place here id of your parent page
                        'order' => 'ASC',
                        'orderby' => 'menu_order'
                    );

                    $childrens = new WP_Query($args);
                    $child_slug = "";
                    if ($childrens->have_posts()) :
                        while ($childrens->have_posts()) : $childrens->the_post();
                            global $post;
                            $child_slug = $post->post_name;
                        endwhile;
                    endif;


                    if (($slug == 'faq' || $current_page_slug == 'about-us') ||
                        $child_slug
                    ) {
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12">
                            <ul class="side-bar">

                                <?php
                                if (is_page()) {
                                    $parent = get_post($post->post_parent);
                                    $parent_title = get_the_title($parent);
                                    $grandparent = $parent->post_parent;
                                    $grandparent_title = get_the_title($grandparent); ?>
                                    <h5 class="pl-4"><?php echo $parent_title; ?></h5>
                                <?php } ?>

                                <div class="separator"></div>

                                <?php
                                // determine parent of current page


                                if ($childrens->have_posts()) : ?>
                                    <ul class="side-menu list-unstyled">
                                        <?php while ($childrens->have_posts()) : $childrens->the_post();
                                            global $post;
                                            $slug = $post->post_name;
                                            $child_slug = $post->post_name;

                                            ?>
                                            <li class="<?php if ($current_page_slug == $child_slug || ($current_page_slug == 'about-us' && $slug == 'faq')) {
                                                echo ($child_slug) ? 'active' : ' ';
                                            }; ?>"><a
                                                        href="<?php the_permalink(); ?>"><?php the_title(); ?> <i
                                                            class="fa fa-angle-right pl-2"></i></a></li>


                                        <?php endwhile; ?>
                                    </ul>
                                <?php endif;
                                wp_reset_query();
                                ?>
                        </div>
                        <?php
                    }
                    ?>


                    <?php
                    global $post;
                    $slug = $post->post_name;
                    if (($slug == 'faq' || $current_page_slug == 'about-us')) {
                        ?>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div id="accordion" class="content-box">

                                <?php
                                global $loop;

                                $args = array('post_type' => 'faq', 'order' => 'ASC', 'posts_per_page' => -1);
                                $loop = new WP_Query($args);
                                $i = 1;
                                if ($loop->have_posts()) :
                                    while ($loop->have_posts()) : $loop->the_post();
                                        $id = get_the_ID();
                                        $show = '';
                                        $aria_expanded = "false";
                                        if ($i == 1) {
                                            $show = "show";
                                            $aria_expanded = "true";

                                        } else {
                                            $show = " ";
                                            $aria_expanded = "false";
                                        }

                                        ?>

                                        <div class="card">
                                            <div class="card-header" id="heading-<?php echo $id; ?>">
                                                <h5 class="mb-0">
                                                    <a class="collapsed" role="button" data-toggle="collapse"
                                                       href="#collapse-<?php echo $id; ?>"
                                                       aria-expanded="<?php echo $aria_expanded; ?>"
                                                       aria-controls="collapse-<?php echo $id; ?>">
                                                        <?php echo the_title(); ?>
                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapse-<?php echo $id; ?>"
                                                 class="collapse <?php echo $show; ?>"
                                                 data-parent="#accordion" aria-labelledby="heading-<?php echo $id; ?>">
                                                <div class="card-body">
                                                    <?php echo the_content(); ?>
                                                </div>
                                            </div>
                                        </div>


                                        <?php $i++; endwhile; ?>
                                    <?php wp_reset_postdata(); ?>
                                <?php else : ?>
                                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                                <?php endif;
                                wp_reset_query();
                                ?>

                            </div>
                        </div>
                        <?php
                    } elseif ($child_slug) { ?>
                        <div class="col-lg-8 col-md-8 col-sm-12">
                            <div class="content-box">
                                <?php
                                $title_icon = get_field('icon');
                                $title_name = get_field('page_title');

                                if (have_posts()):
                                    while (have_posts()) : the_post(); ?>
                                        <div class="card">
                                            <div class="card-header" id="heading-1">
                                                <?php
                                                if ($title_name) {
                                                    ?>
                                                    <h5 class="mb-0">
                                                        <?php
                                                        if ($title_icon) {
                                                            ?>
                                                            <div class="rounded-circle mr-2">
                                                                <img src="<?php echo $title_icon; ?>" alt="title-icon">
                                                            </div>
                                                        <?php }
                                                        ?>
                                                        <?php echo $title_name; ?>
                                                    </h5>
                                                <?php }
                                                ?>

                                            </div>
                                            <div class="collapse show" data-parent="#accordion"
                                                 aria-labelledby="heading-1">
                                                <div class="card-body">
                                                    <?php echo the_content(); ?>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    endwhile;
                                else:?>
                                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                                <?php endif; ?>


                            </div>
                        </div>
                    <?php } else {
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="content-box">
                                <?php
                                if (have_posts()):
                                    while (have_posts()) : the_post(); ?>
                                        <div class="card">
                                            <div class="card-header" id="heading-1">
                                                <h5 class="mb-0">
                                                    <?php echo the_title(); ?>
                                                </h5>
                                            </div>
                                            <div class="collapse show" data-parent="#accordion"
                                                 aria-labelledby="heading-1">
                                                <div class="card-body">
                                                    <?php echo the_content(); ?>
                                                </div>
                                            </div>
                                        </div>

                                    <?php
                                    endwhile;
                                else:?>
                                    <p><?php _e('Sorry, no posts matched your criteria.'); ?></p>
                                <?php endif; ?>


                            </div>
                        </div>
                    <?php }
                    ?>

                </div>

            </div>
        </section>
    </main>
    <!-- /.main start  -->

<?php
get_footer();