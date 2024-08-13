<?php 

class Gutenberg_Square_Slider_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
        add_action( 'acf/init', [ __CLASS__, 'acf_register_local_field_group' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'square-slider-block',
            'title' => 'Блок з квадратним слайдером',
            'description' => '',
            'category' => 'custom',
            'icon' => '',
            'post_types' => ['object', 'building'],
            'keywords' => [],
            'mode' => 'edit',
            'align' => 'full',
            'render_callback' => [ __CLASS__, 'render' ],
            // 'example' => [
            //     'attributes' => [
            //         'mode' => 'preview',
            //         'data' => [
            //             'testimonial' => '',
            //             'author' => '',
            //         ]
            //     ]
            // ]
        ]);

    }

    public static function render( $block, $content = '', $is_preview = false, $post_id = 0 ) {
        $slider = get_field('slider');
        $slider_id = rand(10000, 20000);
        $slider_id_2 = rand(20000, 30000);
        $slider_id_3 = rand(30000, 40000);
        $slider_id_4 = rand(40000, 50000);
        $slider_id_5 = rand(50000, 60000);
        $slider_id_6 = rand(60000, 70000);

        global $pagenow;

        if( $pagenow !== 'post.php' ) : ?>
                <div class="base-damages-one-post__img square__slider">
                    <div class="base-damages-slider swiper " id="slider<?=$slider_id?>">
                        <div class="swiper-wrapper">
                            <?php foreach( $slider as $item ) : ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo $item['image']; ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-prev-damages1 " id="slider<?=$slider_id_2?>">
                            <svg>
                            <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next-damages1 " id="slider<?=$slider_id_3?>">
                            <svg>
                            <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                    </div>
                    <div thumbsSlider="" class="swiper base-damages-gallery " id="slider<?=$slider_id_4?>">
                        <div class="swiper-wrapper">
                            <?php foreach( $slider as $item ) : ?>
                                <div class="swiper-slide">
                                    <img src="<?php echo $item['image']; ?>" />
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="swiper-button-prev-gallery " id="slider<?=$slider_id_5?>">
                            <svg>
                            <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                        <div class="swiper-button-next-gallery " id="slider<?=$slider_id_6?>">
                            <svg>
                            <use xlink:href="#app__arrow-slider-main"></use>
                            </svg>
                        </div>
                    </div>
                </div>
        <?php endif;
    }

    public static function acf_register_local_field_group() {
        
        if ( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_64a2d2754b40d',
                'title' => 'Gutenberg Square Slider Block',
                'fields' => array(
                    array(
                        'key' => 'field_64a2d27892582',
                        'label' => 'Slider',
                        'name' => 'slider',
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
                                'key' => 'field_64a2d29492583',
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
                                'parent_repeater' => 'field_64a2d27892582',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/square-slider-block',
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