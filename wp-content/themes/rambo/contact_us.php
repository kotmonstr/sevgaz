<?php //Template Name: Связаться с нами ?>
   <?php  get_header('second'); ?>
<?php //get_template_part('banner','strip');?>
<!-- Container -->

<?php  my_get_template_part('redline', array('title' => 'НАШИ КОНТАКТЫ')); ?>

<div class="portfolio_main_content">
    <div class="container">

        <div class="row-fluid">
            <div class="Blog_main">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3A479da9303346433e9ed9fb6546182180c89edae0b0c6a9175e04845dd42e5268&amp;source=constructor" width="100%" height="300" frameborder="0"></iframe>
            </div>
        </div>


        <div class="row-fluid all-adress">

            <div id="adress-box" class="Blog_main span6">



                <div class="red-line"></div>
                <div class="caption-tile-about">
                    <p class="caption-text">КОНТАКТНАЯ ИНФОРМАЦИЯ</p>
                </div>


                <div class="cel-adress">
                    <div class="icon-adress icons"></div>
                    <div class="adress-text-bold">Юридический адрес </div>
                    <div class="adress-text">299055, г.Севастополь, пр. Генерала Острякова, д. 17</div>
                </div>

                <div class="cel-adress">
                    <div class="icon-adress icons"></div>
                    <div class="adress-text-bold">Фактический адрес	</div>
                    <div class="adress-text">299055, г.Севастополь, пр. Генерала Острякова, д. 17</div>
                </div>

                <div class="cel-adress" >
                    <div class="icon-mobile icons" ></div>
                    <div class="adress-text-bold">Позвоните нам</div>
                    <div class="adress-text">+7(978)082-62-32</div>
                </div>

                <div class="cel-adress">
                    <div class="icon-clock icons"></div>
                    <div class="adress-text-bold">Рабочие часы</div>
                    <div class="adress-text">9.00-18.00</div>
                </div>

                <div class="cel-adress">
                    <div class="icon-envelope icons"></div>
                    <div class="adress-text-bold">Напишите нам</div>
                    <div class="adress-text">E-mail: <a href="mailto:gup-sevgaz@mail.ru" class="red-link-black-hover">gup-sevgaz@mail.ru</a></div>
                </div>
            </div>

            <div class="Blog_main span6">

                <div class="red-line"></div>
                <div class="caption-tile-about">
                    <p class="caption-text">ВЫ МОЖЕТЕ СВЯЗАТЬСЯ С НАМИ С ПОМОЩЬЮ ЭТОЙ ФОРМЫ</p>
                </div>

                <p>Если Вы хотите получить консультацию, пожалуйста, заполните эту форму:</p>

                         <?php echo do_shortcode('[formidable id=3]'); ?>
            </div>
        </div>
	</div>
</div>
<?php get_footer();?>