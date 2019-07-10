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

// FAQ
function create_faq() {
    register_post_type('faq', array(
        'labels' => array(
            'name'            => __( 'FAQ' ),
            'singular_name'   => __( 'FAQ' ),
            'add_new'         => __( 'Добавить FAQ' ),
            'add_new_item'    => __( 'Добавить FAQ item' ),
            'edit'            => __( 'Редактировать FAQ' ),
            'edit_item'       => __( 'Редактировать FAQ item' ),
            'new_item'        => __( 'FAQ' ),
            'all_items'       => __( 'Все FAQ' ),
            'view'            => __( 'Просмотр FAQ' ),
            'view_item'       => __( 'Просмотр FAQ' ),
            'search_items'    => __( 'Поиск FAQ' ),
            'not_found'       => __( 'FAQ не найден' ),
        ),
        'public' => true, // show in admin panel?
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'taxonomies' => array( ),
        'has_archive' => true,
        'capability_type' => 'post',
        'menu_icon'   => 'dashicons-admin-site',
        'rewrite' => array('slug' => 'faq'),
    ));
}
add_action( 'init', 'create_faq' );
















