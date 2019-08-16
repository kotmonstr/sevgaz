<?php
/*
Template Name: Документы
*/
get_header('second');

$temp = $wp_query;
$wp_query = null;
$wp_query = new WP_Query();
$wp_query->query('showposts=100' . '&paged=' . $paged . '&category_name=docs');
$wp_query_post_first = new WP_Query();
$wp_query_post_first->query('showposts=1' . '&paged=' . $paged . '&category_name=docs');
$i = 0;

if (isset($_GET['post_id'])) {
    $ID = $_GET['post_id'];
    $wp_query_post_first = new WP_Query();
    $wp_query_post_first->query('p=' . $ID . '&category_name=docs' . '&order=DESC');
}

?>

<?php my_get_template_part('redline', array('title' => 'Список Документов')); ?>

    <div class="portfolio_main_content">
        <div class="container" style="background-color:#f6f5f5 ">
            <div class="row" style="margin-bottom: 25px">

                <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                    <?php $i++ ?>

                    <div class="span12">
                        <div class="menu-project content-list-docs">
                            <ul class="list-menu-project">
                                <a href="javascript:void(0)" onclick="showContent(<?php echo get_the_ID() ?>)">
                                    <li id="tab-<?php echo get_the_ID() ?>"  class="main-menu <?php echo isset($ID) && $ID == get_the_ID() || $i == 1 && !isset($ID) ? 'active' : '' ?>"><?php the_title(); ?></li>
                                </a>
                            </ul>
                        </div>
                    </div>

                    <div class="span12 tab-content" id="<?php echo get_the_ID() ?>" style="display: none">
                        <div class="content-project content-tab">
                            <?php while ($wp_query_post_first->have_posts()) : $wp_query_post_first->the_post(); ?>
                                <div class="red-line"></div>
                                <div class="caption-tile-about">
                                    <p class="caption-text " ><?php the_title(); ?></p>
                                </div>
                                <?php the_content(); ?>

                            <?php endwhile; ?>
                        </div>
                    </div>

                <?php endwhile; ?>

            </div>
        </div>
    </div>


<?php
/****** get footer section *********/
get_footer();
?>