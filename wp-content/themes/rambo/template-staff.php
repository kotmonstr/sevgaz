<?php
/*
Template Name: Работники Template
*/
get_header('second');

$temp = $wp_query; $wp_query= null;
$wp_query = new WP_Query(); $wp_query->query('showposts=100' . '&paged='.$paged . '&category_name=staff');
$wp_query_post_first = new WP_Query(); $wp_query_post_first->query('showposts=1' . '&paged='.$paged . '&category_name=staff');
$i=0;

if(isset($_GET['post_id'])){
    $ID = $_GET['post_id'];
    $wp_query_post_first = new WP_Query();
    $wp_query_post_first->query('p='.$ID . '&category_name=staff'. '&order=DESC');
}

?>

<?php my_get_template_part('redline', array('title' => 'НАШИ СОТРУДНИКИ')); ?>

    <div class="portfolio_main_content">
<div class="container"  style="background-color:#f6f5f5 ">


    <div class="row" style="margin-bottom: 25px">

         <div class="span4">
             <div class="menu-project">
                 <ul class="list-menu-project">
                     <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                        <?php $i++ ?>
                         <a href="/sotrudniki/?post_id=<?php echo get_the_ID() ?>"><li class="main-menu <?php echo isset($ID) && $ID == get_the_ID() || $i == 1 && !isset($ID) ? 'active' : ''  ?>"><?php the_title(); ?></li></a>
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
                    <?php  echo get_the_post_thumbnail(); ?>
                    <?php  the_content(); ?>

            <div style="margin-top: 20px">
                    <?php echo "<strong>Должность: </strong> " . get_field('state')."<br>"; ?>
                    <?php echo "<strong>Ответственнен за: </strong> " .get_field('resonsible')."<br>"; ?>
                    <?php echo "<strong>Время приема граждан: </strong> " .get_field('shadiul')."<br>"; ?>
                    <?php echo "<strong>Дополнительная информация: </strong> " .get_field('description')."<br>"; ?>
            </div>
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