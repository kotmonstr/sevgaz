<?php get_header('second');?>


    <div class="purchase_main_content">
        <div class="container">
            <div class="row-fluid purchase_now_content" style="position: relative">
                <div class="" style="text-align: center">
                    <h1 class="red-line-title" style="text-align: center">
                        <?php echo  the_title()?>
                    </h1>
                </div>
                <div class="pull-right" style="position: absolute;top: 0px;right: 0px">
                    <a class="purchase_now_btn" href="/contact-us" target="_blank">СДЕЛАТЬ ЗАПРОС</a>
                </div>
            </div>
        </div>
    </div>



<!-- Container -->
<div class="container" style="margin-top: 25px">
	<!-- Blog Section Content -->
	<div class="row-fluid">
		<!-- Blog Single Page -->
		<div class="span12" style="margin-bottom: 25px">


            <div class="content-project" style="margin-left: 10px">



                    <div class="red-line"></div>
                    <div class="caption-tile-about">
                        <p class="caption-text"><?php  the_title(); ?></p>
                    </div>

                    
                    <?php  the_post(); ?>
                <div class="content-box"><?php  the_content(); ?></div>


            </div>
        </div>


	</div>
</div>
<?php get_footer();?>