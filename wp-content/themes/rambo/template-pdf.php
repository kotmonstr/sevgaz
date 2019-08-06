<?php
/*
Template Name: PDF
*/

get_header('second');

$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); $wp_query->query('showposts=100' . '&paged='.$paged . '&category_name=pdf');
$wp_query_post_first = new WP_Query(); $wp_query_post_first->query('showposts=1' . '&paged='.$paged . '&category_name=pdf');
$i=0;

if(isset($_GET['post_id'])){
    $ID = $_GET['post_id'];
    $wp_query_post_first = new WP_Query();
    $wp_query_post_first->query('p='.$ID . '&category_name=pdf'. '&order=DESC');
}

?>

<?php my_get_template_part('redline', array('title' => 'PDF')); ?>

    <div class="portfolio_main_content">
        <div class="container"  style="background-color:#f6f5f5 ">

            <div class="row" style="margin-bottom: 25px">
                 <div class="span4">
                     <div class="menu-project">
                         <ul class="list-menu-project">
                             <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php $i++ ?>
                                 <a href="/texnologicheskoe-prisoedinenie/baza-normativnyx-aktov/?post_id=<?php echo get_the_ID() ?>"><li class="main-menu <?php echo isset($ID) && $ID == get_the_ID() || $i == 1 && !isset($ID) ? 'active' : ''  ?>"><?php the_title(); ?></li></a>
                             <?php endwhile; ?>
                         </ul>
                    </div>
                 </div>

                <div class="span8">
                    <div class="content-project">
                        <?php while ($wp_query_post_first->have_posts()) : $wp_query_post_first->the_post(); ?>
                            <div class="red-line"></div>
                            <a href="<?php  echo the_field('pdf'); ?>" target="_blank"><button class="button pull-right btn-large btn-default" style="margin-top: -25px;">Просмотреть в новом окне</button></a>
                            <div class="caption-tile-about">
                                <p class="caption-text"><?php  the_title(); ?></p>
                            </div>
                            <iframe src="<?php  echo the_field('pdf'); ?>" width="100%"  style="min-height: 1000px"></iframe>
                        <?php endwhile; ?>
                    </div>
                </div>

            </div>
        </div>
</div>



<?php
get_footer();
?>