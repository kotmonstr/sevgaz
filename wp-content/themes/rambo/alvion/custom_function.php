<?php

function my_get_template_part($template, $data = array()){
    extract($data);
    require locate_template($template.'.php');
}

// STAFF
function create_staff() {
    register_post_type('staff', array(
        'labels' => array(
            'name'            => __( 'Сотрудники' ),
            'singular_name'   => __( 'Сотрудники' ),
            'add_new'         => __( 'Добавить сотрудника' ),
            'add_new_item'    => __( 'Добавить данные сотрудника' ),
            'edit'            => __( 'Редактировать сотрудники' ),
            'edit_item'       => __( 'Редактировать сотрудники item' ),
            'new_item'        => __( 'Сотрудник' ),
            'all_items'       => __( 'Все сотрудники' ),
            'view'            => __( 'Просмотр сотрудника' ),
            'view_item'       => __( 'Просмотр сотрудника' ),
            'search_items'    => __( 'Поиск сотрудника' ),
            'not_found'       => __( 'Сотрудник не найден' ),
        ),
        'public' => true, // show in admin panel?
        'menu_position' => 4,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies' => array( ),
        'has_archive' => true,
        'capability_type' => 'post',
        'menu_icon'   => 'dashicons-admin-users',
        'rewrite' => array('slug' => 'staff'),
    ));
}
add_action( 'init', 'create_staff' );



// NEWS
function create_news() {
    register_post_type('news', array(
        'labels' => array(
            'name'            => __( 'Новости' ),
            'singular_name'   => __( 'Новости' ),
            'add_new'         => __( 'Добавить Новость' ),
            'add_new_item'    => __( 'Добавить Новость' ),
            'edit'            => __( 'Редактировать Новость' ),
            'edit_item'       => __( 'Редактировать Новость' ),
            'new_item'        => __( 'Новость' ),
            'all_items'       => __( 'Все Новости' ),
            'view'            => __( 'Просмотр Новости' ),
            'view_item'       => __( 'Просмотр Новости' ),
            'search_items'    => __( 'Поиск Новости' ),
            'not_found'       => __( 'Новость не найдена' ),
        ),
        'public' => true, // show in admin panel?
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies' => array( ),
        'has_archive' => true,
        'capability_type' => 'post',
        'menu_icon'   => 'dashicons-index-card',
        'rewrite' => array('slug' => 'faq'),
    ));
}
add_action( 'init', 'create_news' );

// FAQ
function create_faq() {
    register_post_type('faq', array(
        'labels' => array(
            'name'            => __( 'FAQ' ),
            'singular_name'   => __( 'FAQ' ),
            'add_new'         => __( 'Добавить FAQ' ),
            'add_new_item'    => __( 'Добавить FAQ' ),
            'edit'            => __( 'Редактировать FAQ' ),
            'edit_item'       => __( 'Редактировать FAQ' ),
            'new_item'        => __( 'FAQ' ),
            'all_items'       => __( 'Все FAQ' ),
            'view'            => __( 'Просмотр FAQ' ),
            'view_item'       => __( 'Просмотр FAQ' ),
            'search_items'    => __( 'Поиск FAQ' ),
            'not_found'       => __( 'FAQ не найден' ),
        ),
        'public' => true, // show in admin panel?
        'menu_position' => 6,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies' => array( ),
        'has_archive' => true,
        'capability_type' => 'post',
        'menu_icon'   => 'dashicons-editor-help',
        'rewrite' => array('slug' => 'faq'),
    ));
}
add_action( 'init', 'create_faq' );// FAQ


function create_slider() {
    register_post_type('slider', array(
        'labels' => array(
            'name'            => __( 'Слайды' ),
            'singular_name'   => __( 'Слайды' ),
            'add_new'         => __( 'Добавить Слайд' ),
            'add_new_item'    => __( 'Добавить Слайд' ),
            'edit'            => __( 'Редактировать Слайд' ),
            'edit_item'       => __( 'Редактировать Слайд' ),
            'new_item'        => __( 'Слайд' ),
            'all_items'       => __( 'Все Слайды' ),
            'view'            => __( 'Просмотр Слайда' ),
            'view_item'       => __( 'Просмотр Слайда' ),
            'search_items'    => __( 'Поиск Слайда' ),
            'not_found'       => __( 'Слайд не найден' ),
        ),
        'public' => true, // show in admin panel?
        'menu_position' => 7,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies' => array('slider'),
        'has_archive' => true,
        'capability_type' => 'post',
        'menu_icon'   => 'dashicons-tickets-alt',
        'rewrite' => array('slug' => 'slider'),


    ));
}
add_action( 'init', 'create_slider' );




// Создаем новую таксономию для аксессуаров
add_action( 'init', 'create_acsessuar_taxonomies', 0 );

function create_acsessuar_taxonomies(){
    $labels = array(
        'name' => _x( 'Слайды', 'slider' ),
        'singular_name' => _x( 'Слайд', 'slider' ),
        'search_items' =>  __( 'Найти категорию аксессуаров' ),
        'all_items' => __( 'Слайды' ),
        'parent_item' => __( 'Родительская категория аксессуара' ),
        'parent_item_colon' => __( 'Родительская категория' ),
        'edit_item' => __( 'Родительская категория' ),
        'update_item' => __( 'Обновить катгорию' ),
        'add_new_item' => __( 'Добавить новую катгорию' ),
        'new_item_name' => __( 'Название новой категории аксессуаров' ),
        'menu_name' => __( 'Категории аксессуаров' ),
    );

    register_taxonomy('slider', array('slider'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'slider' ),
    ));

}




## Добавляет миниатюры записи в таблицу записей в админке
if (1) {
    add_action('init', 'add_post_thumbs_in_post_list_table', 20);
    function add_post_thumbs_in_post_list_table()
    {
        // проверим какие записи поддерживают миниатюры
        $supports = get_theme_support('post-thumbnails');

        // $ptype_names = array('post','page'); // указывает типы для которых нужна колонка отдельно

        // Определяем типы записей автоматически
        if (!isset($ptype_names)) {
            if ($supports === true) {
                $ptype_names = get_post_types(array('public' => true), 'names');
                $ptype_names = array_diff($ptype_names, array('attachment'));
            } // для отдельных типов записей
            elseif (is_array($supports)) {
                $ptype_names = $supports[0];
            }
        }

        // добавляем фильтры для всех найденных типов записей
        foreach ($ptype_names as $ptype) {
            add_filter("manage_{$ptype}_posts_columns", 'add_thumb_column');
            add_action("manage_{$ptype}_posts_custom_column", 'add_thumb_value', 10, 2);
        }
    }

    // добавим колонку
    function add_thumb_column($columns)
    {
        // подправим ширину колонки через css
        add_action('admin_notices', function () {
            echo '
	<style>
	.column-thumbnail{ width:80px; text-align:center; }
	</style>';
        });

        $num = 1; // после какой по счету колонки вставлять новые

        $new_columns = array('thumbnail' => __('Thumbnail'));

        return array_slice($columns, 0, $num) + $new_columns + array_slice($columns, $num);
    }

    // заполним колонку
    function add_thumb_value($colname, $post_id)
    {
        if ('thumbnail' == $colname) {
            $width = $height = 45;

            // миниатюра
            if ($thumbnail_id = get_post_meta($post_id, '_thumbnail_id', true)) {
                $thumb = wp_get_attachment_image($thumbnail_id, array($width, $height), true);
            } // из галереи...
            elseif ($attachments = get_children(array(
                'post_parent' => $post_id,
                'post_mime_type' => 'image',
                'post_type' => 'attachment',
                'numberposts' => 1,
                'order' => 'DESC',
            ))) {
                $attach = array_shift($attachments);
                $thumb = wp_get_attachment_image($attach->ID, array($width, $height), true);
            }

            echo empty($thumb) ? ' ' : $thumb;
        }
    }
}
















