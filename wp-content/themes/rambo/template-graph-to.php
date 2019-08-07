<?php
/*
Template Name: Графики проведения ТО
*/

get_header('second');

$currYear = $_GET['postY'];
//var_dump($currYear);
$temp = $wp_query; $wp_query= null;

if(isset($currYear)){
    $wp_query = new WP_Query(); $wp_query->query('showposts=100' . '&paged='.$paged . '&category_name=graf'. '&year='.$currYear);

    //var_dump($wp_query); die();
}else{
    $wp_query = new WP_Query(); $wp_query->query('showposts=100' . '&paged='.$paged . '&category_name=graf');
}

$wp_query_post_first = new WP_Query(); $wp_query_post_first->query('showposts=1' . '&paged='.$paged . '&category_name=graf');



// Работа со временем
$arrDataY = array();
$arrDataM = array();
$wp_query2 = new WP_Query(); $wp_query2->query('showposts=100' . '&paged='.$paged . '&category_name=graf');
while ($wp_query2->have_posts()) : $wp_query2->the_post();
    $arrDataY[]= date("Y",get_post_time());
    $arrDataM[]= date("m",get_post_time());
endwhile;

//var_dump($arrDataY);die();
$arrDataY = array_unique($arrDataY); // Года
$arrDataM = array_unique($arrDataM); // Месяцы

var_dump($arrDataY);
var_dump($arrDataM);





$i=0;

if(isset($_GET['post_id'])){
    $ID = $_GET['post_id'];
    $wp_query_post_first = new WP_Query();
    $wp_query_post_first->query('p='.$ID . '&category_name=graf'. '&order=DESC');
}

?>

<?php my_get_template_part('redline', array('title' => 'Графики проведения ТО')); ?>

    <div class="portfolio_main_content">
        <div class="container"  style="background-color:#f6f5f5 ">

            <div class="row" style="margin-bottom: 25px">
                <div class="span2">
                    <div class="menu-project">
                        <ul class="list-menu-project">
                            <?php foreach ($arrDataY as $Y){; ?>
                                <a href="/grafiki-provedeniya-to/?postY=<?php echo $Y; ?>"><li class="main-menu <?php echo $Y == $currYear ? 'active' : '' ?>"><?php echo $Y; ?></li></a>
                            <?php } ?>
                        </ul>
                    </div>
                </div>

<?php if(isset($currYear)) { ?>

                <div class="span4">
                    <div class="menu-project">
                        <ul class="list-menu-project">
                            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                                <?php $i++ ?>
                                <a href="/grafiki-provedeniya-to/?post_id=<?php echo get_the_ID() ?>"><li class="main-menu <?php echo isset($ID) && $ID == get_the_ID() || $i == 1 && !isset($ID) ? 'active' : ''  ?>"><?php the_title(); ?></li></a>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
<?php } ?>
<?php if(isset($ID)) { ?>
                <div class="span4">
                    <div class="content-project">
                        <?php while ($wp_query_post_first->have_posts()) : $wp_query_post_first->the_post(); ?>
                            <div class="red-line"></div>
                            <div class="caption-tile-about">
                                <p class="caption-text"><?php  the_title(); ?></p>


                            <a href="<?php  echo the_field('zip'); ?>" ><button class="button pull-right btn-large btn-default" style="margin-top: -25px;">Скачать</button></a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
<?php } ?>


<?php
get_footer();
?>