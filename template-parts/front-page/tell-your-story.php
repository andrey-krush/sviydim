<?php

class Front_Page_Tell_Your_Story {

    public function __construct() {
        $tell_your_story_section = get_field( 'tell_your_story_section' );

        $this->title = $tell_your_story_section['title'];
        $this->title = str_replace( '[', '<span class="word" >', $this->title );
        $this->title = str_replace( ']', '</span>', $this->title );

        $this->subtitle = $tell_your_story_section['subtitle'];
        $this->button = $tell_your_story_section['button'];
        $this->left_image = $tell_your_story_section['left_image'];
        $this->right_image = $tell_your_story_section['right_image'];
    }

    public function render() {
        ?>

        <section class="main-tell-history">
            <div class="container">
                <div class="main-tell-history__wrapper">
                    <?php if( !empty( $this->title ) ) : ?>
                        <h2><?php echo $this->title; ?></h2>
                    <?php endif; ?>
                    <?php if( !empty( $this->subtitle ) ) : ?>
                        <h3><?php echo $this->subtitle; ?></h3>
                    <?php endif; ?>
                    <?php if( !empty( $this->button ) ) : ?>
                        <a href="<?php echo $this->button['url']; ?>" target="_blank" class="text-button-bold button-primary"><?php echo $this->button['title']; ?></a>
                    <?php endif; ?>
                    <?php if( !empty( $this->left_image ) ) : ?>
                        <div class="main-tell-history-left">
                            <img src="<?php echo $this->left_image; ?>" />
                        </div>
                    <?php endif; ?>
                    <?php if( !empty( $this->right_image ) ) : ?>
                        <div class="main-tell-history-right">
                            <img src="<?php echo $this->right_image; ?>" />
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php
    }
}