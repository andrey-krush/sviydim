<?php 

class Gutenberg_Ukraine_Remember_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'ukraine-remember-block',
            'title' => 'Блок "Україна памятає"',
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
        $title = get_field('title'); 
        $subtitle = str_replace( '[', '<span>', get_field('subtitle')); 
        $subtitle = str_replace( ']', '</span>', $subtitle); ?>
            <div class="ukraine-remember">
                <?php if( !empty( $title ) ) : ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if( !empty( $subtitle ) ) : ?>
                    <h3><?php echo $subtitle; ?></h3>
                <?php endif; ?>
                <div class="icon-ukr">
                    <svg>
                    <use xlink:href="#app__icon-ukr"></use>
                    </svg>
                </div>
            </div>
        <?php 
    }
}