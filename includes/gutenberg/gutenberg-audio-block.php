<?php 

class Gutenberg_Audio_Block {

    public static function init() {
        add_action( 'acf/init', [ __CLASS__, 'acf_register_block_type' ] );
    }

    public static function acf_register_block_type() {

        acf_register_block_type( [
            'name' => 'audio-block',
            'title' => 'Блок з аудіо',
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
        $audio_file = get_field('audio_file');
        if( !empty( $audio_file ) ) : ?>
            <div class="audio-tag">
                <audio controls>
                    <source src="<?php echo $audio_file; ?>" type="audio/mpeg"> Ваш браузер не підтримує фотмат даних аудіо фвйлів.
                </audio>
            </div>
        <?php endif; 
    }
}