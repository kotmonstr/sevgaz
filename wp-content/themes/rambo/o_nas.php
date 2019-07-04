<?php //Template Name:О нас ?>
<?php get_header('second');?>
<?php
    $temp = $wp_query; $wp_query= null;
    $wp_query = new WP_Query(); $wp_query->query('showposts=30&category_name=o-kompanii');
    $wp_query2 = new WP_Query(); $wp_query2->query('showposts=30&category_name=staff');
?>


<?php my_get_template_part('redline', array('title' => 'О КОМПАНИИ')); ?>


<div class="portfolio_main_content">
    <div class="container">

        <div class="row-fluid featured_port_title" >

            <div class="red-line"></div>
            <div class="caption-tile-about">
                <p class="caption-text">Факты о компании</p>
                <p class="red-title">Большому кораблю - большое плавание</p>
            </div>





        </div>
        <div class="row">
            <?php while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
                <div class="span4">
                    <div class="box-copany-descr" style="position: relative">
                        <a href="<?php echo get_permalink() ?>">
                            <div class="featured_port_projects "><?php echo get_the_post_thumbnail(); ?></div>

                            <p class="title-upercase"><?php echo the_title(); ?></p>
                            <div class="red-line"></div>
                        <p><?php echo wp_trim_words( get_the_content(), $num_words = 30, $more = null ); ?></p>

                        </a>
                        <a href="<?php echo get_permalink() ?>" class="red-link-fl-right">читать >> </a>
                    </div>

                </div>
            <?php endwhile; ?>
        </div>
    </div>
</div>

<?php
get_template_part('statisticbar') ;
?>



<div class="portfolio_main_content">
    <div class="container">
        <div class="row-fluid featured_port_title ">
            <div class="caption-tile-about">
                <div class="red-line"></div>
                <p class="caption-text">Наша команда</p>
                <p class="red-title">Дружный коллектив Севастопольгаз</p>
                <p>Мы объединяем наши усилия, чтобы результат был впечатляющим. Встречайте нашу талантливую, профессиональную команду! Это люди, котрые создают все наши проекты. Вместе мы делаем одно важное дело - дизайн, конструирование и строительство для людей. </p>
            </div>
        </div>
        <div class="row" id="comanda-descr">
            <?php while ($wp_query2->have_posts()) : $wp_query2->the_post(); ?>
                <div class="span3">
                    <a href="<?php echo get_permalink() ?>">
                        <div class="featured_port_projects "><?php echo get_the_post_thumbnail(); ?></div>
                        <h3><?php echo the_field( 'fio',get_the_ID()); ?></h3>
                        <p><?php echo the_field( 'state',get_the_ID()); ?></p>
                    </a>

                </div>
            <?php endwhile; ?>
        </div>

	</div>
</div>

<?php
get_template_part('index','testimonals') ;
?>

<?php get_footer();?>