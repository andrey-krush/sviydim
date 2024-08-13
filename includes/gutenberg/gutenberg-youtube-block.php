<?php 

class Gutenberg_Youtube_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'youtube-block',
            'title' => 'Блок з ютубом',
            'description' => '',
            'category' => 'custom',
            'icon' => '',
            'post_types' => ['building', 'object'],
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
        $youtube_frame = get_field('youtube_frame');
        if( !empty( $youtube_frame ) ) : ?>
            <div class="video-tag">
                <?php if( !empty( $title ) ) : ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php echo $youtube_frame; ?>
            </div>
        <?php endif; 
    }

}