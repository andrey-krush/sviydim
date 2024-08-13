<?php 

class Gutenberg_Quote_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'quote-block',
            'title' => 'Блок з цитатою',
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
        $quote = get_field('quote');
        if( !empty( $quote ) ) : ?>
            <div class="quote">
                <svg>
                    <use xlink:href="#app__quote"></use>
                </svg>
                <h2><?php echo $quote; ?></h2>
            </div>
        <?php endif; 
    }

}