<?php 

class Type_Object {

    public static function init() {
        add_action('init', [__CLASS__, 'register_type']);
        add_action('init', [__CLASS__, 'register_object_type_taxonomy']);
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);
    } 

    public static function register_type() {
        register_post_type( 'object', [
            'label'  => null,
            'labels' => [
                'name'               => "Об'єкти", 
                'singular_name'      => "Об'єкт", 
                'add_new'            => "Додати об'єкт", 
                'add_new_item'       => "Додавання об'єкту", 
                'edit_item'          => "Редагування об'єкту", 
                'new_item'           => "Новий об'єкт", 
                'view_item'          => "Переглянути об'єкт", 
                'search_items'       => "Шукати об'єкт", 
                'not_found'          => "Не знайдено", 
                'not_found_in_trash' => "Не знайдено в корзині", 
                'parent_item_colon'  => '', 
                'menu_name'          => "Об'єкти", 
            ],
            'has_archive' => true,
            'public' => true,
            'show_in_rest' => true,
            'show_ui' => true, 
            'supports' => array( 'title', 'thumbnail', 'editor', 'author')
        ] );
    }

    public static function register_object_type_taxonomy(){

        register_taxonomy( 'object_type', [ 'object' ], [
            'label'                 => '', 
            'labels'                => [
                'name'              => "Типи об'єктів",
                'singular_name'     => "Тип об'єкту",
                'search_items'      => "Пошук типів об'єктів",
                'all_items'         => "Усі типи об'єктів",
                'view_item '        => "Переглянути тип об'єкту",
                'parent_item'       => "Parent Type",
                'parent_item_colon' => "Parent Type:",
                'edit_item'         => "Редагувати тип об'єкту",
                'update_item'       => "Оновити тип об'єкту",
                'add_new_item'      => "Додати тип об'єкту",
                'new_item_name'     => "Новий тип об'єкту",
                'menu_name'         => "Типи об'єктів",
                'back_to_items'     => "Назад до типів",
            ],
            'description'           => '',
            'public'                => true,
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'rewrite'               => array( 'slug' => null, 'with_front' => false ,'hierarchical' => true)
        ] );
    }
    
    public static function acf_add_local_field_group() {

        if ( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_647dccaa889ef',
                'title' => 'Object',
                'fields' => array(
                    array(
                        'key' => 'field_647dccab09305',
                        'label' => 'Post info',
                        'name' => '',
                        'aria-label' => '',
                        'type' => 'tab',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'placement' => 'top',
                        'endpoint' => 0,
                    ),
                    array(
                        'key' => 'field_647dcce209306',
                        'label' => '',
                        'name' => 'post_info',
                        'aria-label' => '',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_64a284848033e',
                                'label' => 'Slider choose',
                                'name' => 'slider_choose',
                                'aria-label' => '',
                                'type' => 'true_false',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'message' => '',
                                'default_value' => 0,
                                'ui_on_text' => 'Прямокутний',
                                'ui_off_text' => 'Квадратний',
                                'ui' => 1,
                            ),
                            array(
                                'key' => 'field_647dccf209307',
                                'label' => 'Slider',
                                'name' => 'slider',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_64a284848033e',
                                            'operator' => '!=',
                                            'value' => '1',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'layout' => 'table',
                                'pagination' => 0,
                                'min' => 0,
                                'max' => 0,
                                'collapsed' => '',
                                'button_label' => 'Додати рядок',
                                'rows_per_page' => 20,
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_647dccf909308',
                                        'label' => '',
                                        'name' => 'image',
                                        'aria-label' => '',
                                        'type' => 'image',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'return_format' => 'url',
                                        'library' => 'all',
                                        'min_width' => '',
                                        'min_height' => '',
                                        'min_size' => '',
                                        'max_width' => '',
                                        'max_height' => '',
                                        'max_size' => '',
                                        'mime_types' => '',
                                        'preview_size' => 'medium',
                                        'parent_repeater' => 'field_647dccf209307',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_64a285a68033f',
                                'label' => 'Slider (rectangle)',
                                'name' => 'slider_rectangle',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_64a284848033e',
                                            'operator' => '==',
                                            'value' => '1',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'layout' => 'table',
                                'pagination' => 0,
                                'min' => 0,
                                'max' => 0,
                                'collapsed' => '',
                                'button_label' => 'Додати рядок',
                                'rows_per_page' => 20,
                                'sub_fields' => array(
                                    array(
                                        'key' => 'field_64a285a680340',
                                        'label' => '',
                                        'name' => 'image',
                                        'aria-label' => '',
                                        'type' => 'image',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'return_format' => 'url',
                                        'library' => 'all',
                                        'min_width' => '',
                                        'min_height' => '',
                                        'min_size' => '',
                                        'max_width' => '',
                                        'max_height' => '',
                                        'max_size' => '',
                                        'mime_types' => '',
                                        'preview_size' => 'medium',
                                        'parent_repeater' => 'field_64a285a68033f',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_647dcd130930a',
                                'label' => 'Ruin date',
                                'name' => 'ruin_date',
                                'aria-label' => '',
                                'type' => 'date_picker',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'display_format' => 'd/m/Y',
                                'return_format' => 'Y-m-d',
                                'first_day' => 1,
                            ),
                            array(
                                'key' => 'field_647dcd5a0930b',
                                'label' => 'Related posts',
                                'name' => 'related_posts',
                                'aria-label' => '',
                                'type' => 'relationship',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'post_type' => array(
                                    0 => 'building',
                                ),
                                'post_status' => array(
                                    0 => 'publish',
                                ),
                                'taxonomy' => '',
                                'filters' => array(
                                    0 => 'search',
                                    1 => 'taxonomy',
                                ),
                                'return_format' => 'id',
                                'min' => '',
                                'max' => '',
                                'elements' => '',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'object',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
                'show_in_rest' => 0,
            ));
            
        endif;    
            
    }

}