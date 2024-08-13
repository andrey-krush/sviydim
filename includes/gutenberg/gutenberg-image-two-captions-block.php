<?php 

class Gutenberg_Image_Two_Captions_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'image-two-captions-block',
            'title' => 'Блок з картинкою і 2 підписами',
            'description' => '',
            'category' => 'custom',
            'icon' => '',
            'post_types' => ['building'],
            'keywords' => [],
            'mode' => 'auto',
            'align' => 'full',
            'render_callback' => [ __CLASS__, 'render' ],
            'example' => [
                'attributes' => [
                    'mode' => 'preview',
                    'data' => [
                        'testimonial' => '',
                        'author' => '',
                    ]
                ]
            ]
        ]);

    }

    public static function render( $block, $content = '', $is_preview = false, $post_id = 0 ) {
        $image = get_field('image');
        $first_caption = get_field('first_caption');
        $second_caption = get_field('second_caption');
        if( !empty( $image ) ) : ?>
            <div class="post-img">
                <img src="<?php echo $image; ?>" />
                <div class="post-img__wrapper">
                    <?php if( !empty( $first_caption ) ) : ?>
                        <p><?php echo $first_caption; ?></p>
                    <?php endif; ?>
                    <?php if( !empty( $second_caption ) ) : ?>
                        <p><?php echo $second_caption; ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; 
    }
}