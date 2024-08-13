<?php 

class Type_Building {

    public static function init() {
        add_action('init', [__CLASS__, 'register_type'], 40);
        add_action('init', [__CLASS__, 'register_building_type_taxonomy']);
        add_action('init', [__CLASS__, 'registerBuildingTag']);
        add_action('init', [__CLASS__, 'register_story_type_taxonomy']);
        add_action('acf/init', [__CLASS__, 'acf_add_local_field_group']);

        add_filter( 'post_type_link', [__CLASS__, 'building_permalink'], 1, 2 );
        add_action('wp_ajax_get_regions_by_area', [__CLASS__, 'get_regions_by_area']);
        add_action('wp_ajax_nopriv_get_regions_by_area', [__CLASS__, 'get_regions_by_area']);

        add_action('wp_ajax_get_settlements_by_region', [__CLASS__, 'get_settlements_by_region']);
        add_action('wp_ajax_nopriv_get_settlements_by_region', [__CLASS__, 'get_settlements_by_region']);

        add_action('wp_ajax_get_streets_by_settlement', [__CLASS__, 'get_streets_by_settlement']);
        add_action('wp_ajax_nopriv_get_streets_by_settlement', [__CLASS__, 'get_streets_by_settlement']);

        add_action('wp_ajax_nopriv_search_settlements', [__CLASS__, 'search_settlements']);
        add_action('wp_ajax_search_settlements', [__CLASS__, 'search_settlements']);

        add_action('wp_ajax_nopriv_generate_base_damage_url', [__CLASS__, 'generate_base_damage_url']);
        add_action('wp_ajax_generate_base_damage_url', [__CLASS__, 'generate_base_damage_url']);
    } 

    public static function register_type() {
        register_post_type( 'building', [
            'label'  => null,
            'labels' => [
                'name'               => 'Будівлі', 
                'singular_name'      => 'Будівля', 
                'add_new'            => 'Додати будівлю', 
                'add_new_item'       => 'Додавання будівлі', 
                'edit_item'          => 'Редагування будівлі', 
                'new_item'           => 'Нова будівлі', 
                'view_item'          => 'Переглянути будівлі', 
                'search_items'       => 'Шукати будівлю', 
                'not_found'          => 'Не знайдено', 
                'not_found_in_trash' => 'Не знайдено в корзині', 
                'parent_item_colon'  => '', 
                'menu_name'          => 'Будівлі', 
            ],
            'has_archive' => true,
            'public' => true,
            'rewrite' => array( 'slug'=>'articles/%story_type%'),
            'show_in_rest' => true,
            'show_ui' => true, 
            'supports' => array( 'title', 'thumbnail', 'editor', 'author')
        ] );
    }

    public static function building_permalink( $permalink, $post ){

        if( strpos( $permalink, '%story_type%' ) === false ){
            return $permalink;
        }
    
        $terms = get_the_terms( $post, 'story_type' );

        if( ! is_wp_error( $terms ) && !empty( $terms ) && is_object( $terms[0] ) ){
            $term_slug = array_pop( $terms )->slug;
        }
    
        return str_replace( '%story_type%', $term_slug, $permalink );
    }
    

    public static function register_building_type_taxonomy(){

        register_taxonomy( 'building_type', [ 'building' ], [
            'label'                 => '', 
            'labels'                => [
                'name'              => 'Типи будівель',
                'singular_name'     => 'Тип будівлі',
                'search_items'      => 'Пошук типів будівель',
                'all_items'         => 'Усі типи будівель',
                'view_item '        => 'Переглянути тип будівлі',
                'parent_item'       => 'Parent Type',
                'parent_item_colon' => 'Parent Type:',
                'edit_item'         => 'Редагувати тип будівлі',
                'update_item'       => 'Оновити тип будівлі',
                'add_new_item'      => 'Додати тип будівлі',
                'new_item_name'     => 'Новий тип будівлі',
                'menu_name'         => 'Типи будівель',
                'back_to_items'     => 'Назад до типів',
            ],
            'description'           => '',
            'public'                => true,
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'rewrite'               => array( 'slug' => null, 'with_front' => false ,'hierarchical' => true)
        ] );
    }

    public static function register_story_type_taxonomy(){

        register_taxonomy( 'story_type', [ 'building' ], [
            'label'                 => '', 
            'labels'                => [
                'name'              => 'Типи історій',
                'singular_name'     => 'Тип історії',
                'search_items'      => 'Пошук типів історій',
                'all_items'         => 'Усі типи будівель',
                'view_item '        => 'Переглянути тип історії',
                'parent_item'       => 'Parent Type',
                'parent_item_colon' => 'Parent Type:',
                'edit_item'         => 'Редагувати тип історії',
                'update_item'       => 'Оновити тип історії',
                'add_new_item'      => 'Додати тип історії',
                'new_item_name'     => 'Новий тип історії',
                'menu_name'         => 'Типи історій',
                'back_to_items'     => 'Назад до типів',
            ],
            'public'                => true,
            'rewrite' => array( 'slug'=>'article'),
            'hierarchical'          => true,
            'show_ui'               => true,
            'show_in_rest'          => true,
            'publicly_queryable'    => true, 
		    'show_in_nav_menus'     => true, 
        ] );
    }

    public static function registerBuildingTag() {

        register_taxonomy( 'building_tag', [ 'building' ], [
            'label'                 => '', // определяется параметром $labels->name
            'labels'                => [
                'name'              => 'Теги',
                'singular_name'     => 'Тег',
                'search_items'      => 'Пошук Тегів',
                'all_items'         => 'Усі Теги',
                'view_item '        => 'Показти Тег',
                'parent_item'       => 'Батьківський Тег',
                'parent_item_colon' => 'Батьківський Тег:',
                'edit_item'         => 'Редагувати Тег',
                'update_item'       => 'Оновити Тег',
                'add_new_item'      => 'Додати новий тег',
                'new_item_name'     => 'Новий Тег',
                'menu_name'         => 'Теги',
                'back_to_items'     => '← Назад до Тегу',
            ],
            'description'           => '',
            'public'                => true,
            'publicly_queryable'    => true,
            'show_in_nav_menus'     => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'show_in_rest'          => true,
            'show_tagcloud'         => true,
            'show_in_quick_edit'    => true,
            'hierarchical'          => false,
            'show_admin_column'     => true,
            'rewrite'               => array( 'slug' => null, 'with_front' => false ,'hierarchical' => true)
        ] );
//        register_taxonomy_for_object_type('post_tag', 'building');
    }

    public static function get_regions_by_area() {

        global $wpdb;

        if( !empty( $_POST['area'] ) ) : 

            $area_id = (int) $_POST['area'];

            $regions = $wpdb->get_results( "SELECT ID, Name FROM wp_regions WHERE area_id=". $area_id ." ORDER BY name", ARRAY_A);

            wp_send_json_success( array( 'regions' => $regions ) );

            die;
        
        endif;

    }

    public static function get_settlements_by_region() {
        
        global $wpdb;

        if( !empty( $_POST['region'] ) ) : 

            $region_id = (int) $_POST['region'];

            $settlements = $wpdb->get_results( "SELECT ID, Name  FROM wp_settlements WHERE region_id=". $region_id ." ORDER BY Name ", ARRAY_A);

            wp_send_json_success( array( 'settlements' => $settlements ) );

            die;
        
        endif;

    }

    public static function get_streets_by_settlement() {
        
        global $wpdb;

        if( !empty( $_POST['settlement'] ) ) :

            $settlement_id = (int) $_POST['settlement'];

            $streets = $wpdb->get_results( "SELECT ID, Name  FROM wp_streets WHERE settlement_id=". $settlement_id ." ORDER BY Name ", ARRAY_A);

            wp_send_json_success( array( 'streets' => $streets ) );

            die;
        
        endif;

    }

    public static function search_settlements() {

        global $wpdb;

        if( !empty( $_POST['search'] ) ) : 

            $settlements = $wpdb->get_results( "SELECT ID, Name FROM wp_settlements WHERE Name LIKE '%" . $_POST['search'] . "%' ORDER BY Name ", ARRAY_A);
            wp_send_json_success( array( 'settlements' => $settlements ) );

        endif;

    }

    public static function generate_base_damage_url() {

        global $wpdb; 

        if( !empty( $_POST['settlement_id'] ) ) : 

            $region_id = $wpdb->get_results( "SELECT region_id FROM wp_settlements WHERE ID = " . $_POST['settlement_id'] . " ", ARRAY_A)[0]['region_id'];
            $area_id = $wpdb->get_results( "SELECT area_id FROM wp_regions WHERE ID = " . $region_id . " ", ARRAY_A)[0]['area_id'];

            $base_damage_link = get_post_type_archive_link( 'object' ) . '?region=' . $region_id . '&area=' . $area_id . '&settlement=' . $_POST['settlement_id'];
            wp_send_json_success( array( 'base_damage_link' => $base_damage_link ) );

        endif;

    }

    public static function acf_add_local_field_group() {

        if ( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_646e055b70434',
                'title' => 'Building',
                'fields' => array(
                    array(
                        'key' => 'field_646e055d9f612',
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
                        'key' => 'field_646e05719f613',
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
                                'key' => 'field_64a2b0df068f4',
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
                                'key' => 'field_64749d0e37513',
                                'label' => 'Slider images',
                                'name' => 'slider_images',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_64a2b0df068f4',
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
                                        'key' => 'field_64749d1c37514',
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
                                        'parent_repeater' => 'field_64749d0e37513',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_64a2b11f068f6',
                                'label' => 'Slider images (rectangle)',
                                'name' => 'slider_images_rectangle',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_64a2b0df068f4',
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
                                        'key' => 'field_64a2b11f068f7',
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
                                        'parent_repeater' => 'field_64a2b11f068f6',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_646e05789f614',
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
                                'key' => 'field_6474a653f8c75',
                                'label' => 'Tags',
                                'name' => 'tags',
                                'aria-label' => '',
                                'type' => 'repeater',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
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
                                        'key' => 'field_6474a661f8c76',
                                        'label' => '',
                                        'name' => 'tag',
                                        'aria-label' => '',
                                        'type' => 'text',
                                        'instructions' => '',
                                        'required' => 0,
                                        'conditional_logic' => 0,
                                        'wrapper' => array(
                                            'width' => '',
                                            'class' => '',
                                            'id' => '',
                                        ),
                                        'default_value' => '',
                                        'maxlength' => '',
                                        'placeholder' => '',
                                        'prepend' => '',
                                        'append' => '',
                                        'parent_repeater' => 'field_6474a653f8c75',
                                    ),
                                ),
                            ),
                            array(
                                'key' => 'field_64a555ba61edb',
                                'label' => 'Recommended post',
                                'name' => 'recommended_post',
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
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                                'ui' => 1,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'building',
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
            
        if ( function_exists('acf_add_local_field_group') ):
            
            acf_add_local_field_group(array(
                'key' => 'group_646e0149e3653',
                'title' => 'Building type',
                'fields' => array(
                    array(
                        'key' => 'field_646e014c4ae88',
                        'label' => 'Category icon',
                        'name' => 'category_icon',
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
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'building_type',
                        ),
                    ),
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'object_type',
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
            
        if ( function_exists('acf_add_local_field_group') ):
            
            acf_add_local_field_group(array(
                'key' => 'group_6481dc90e8882',
                'title' => 'Story type',
                'fields' => array(
                    array(
                        'key' => 'field_6481dc9203ccc',
                        'label' => 'Top posts',
                        'name' => 'top_posts',
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
                            1 => 'object',
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
                    array(
                        'key' => 'field_6481dced03ccd',
                        'label' => 'Form title',
                        'name' => 'form_title',
                        'aria-label' => '',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'maxlength' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                    ),
                    array(
                        'key' => 'field_6481de5003cce',
                        'label' => 'Form button',
                        'name' => 'form_button',
                        'aria-label' => '',
                        'type' => 'link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'story_type',
                        ),
                    ),
                    array(
                        array(
                            'param' => 'taxonomy',
                            'operator' => '==',
                            'value' => 'building_tag',
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