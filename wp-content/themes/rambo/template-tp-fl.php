<?php
/*
Template Name: ТП физические лица
*/
get_header('second');

$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); $wp_query->query('&category_name=form');
$wp_query_post_first = new WP_Query(); $wp_query_post_first->query('showposts=1' . '&category_name=form');
$i=0;

if(isset($_GET['post_id'])){
    $ID = $_GET['post_id'];
    $wp_query_post_first = new WP_Query();
    $wp_query_post_first->query('p='.$ID . '&category_name=form'. '&order=DESC');
}

?>

<?php my_get_template_part('redline', array('title' => 'Технологическое подключение физического лица')); ?>

    <div class="portfolio_main_content">
<div class="container"  style="background-color:#f6f5f5 ">


    <div class="row" style="margin-bottom: 25px">

         <div class="span4">
             <div class="menu-project">
                 <ul class="list-menu-project">
                     <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <?php $i++ ?>
                         <a href="/texnologicheskoe-prisoedinenie/tp-fizicheskie-lica-2/?post_id=<?php echo get_the_ID() ?>"><li class="main-menu <?php echo isset($ID) && $ID == get_the_ID() || $i == 1 && !isset($ID) ? 'active' : ''  ?>"><?php the_title(); ?></li></a>
                     <?php endwhile; ?>
                 </ul>
            </div>
         </div>

        <div class="span8">
            <div class="content-project">
                <?php while ($wp_query_post_first->have_posts()) : $wp_query_post_first->the_post(); ?>
                    <div class="red-line"></div>
                    <div class="caption-tile-about">
                        <p class="caption-text"><?php  the_title(); ?></p>
                    </div>

                    <?php  the_content(); ?>
                <?php endwhile; ?>
            </div>
        </div>

    </div>
</div>
</div>



<?php
/****** get footer section *********/
get_footer();
?>