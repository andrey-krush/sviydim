<?php 

class Questions_Page_Content {

    public function __construct() {
        $this->title = get_the_title();
        $content = get_field('content');
        $this->text = $content['text'];
        $this->faq = $content['faq'];
        $this->main_page_link = get_the_permalink(get_option('page_on_front'));
    }

    public function render() {
        ?>

        <section class="questions">
            <div class="container">
                <div class="questions-header">
                    <h1><?php echo $this->title; ?></h1>
                    <div class="navigator">
                        <h5><a href="<?php echo $this->main_page_link; ?>">головна</a> / <?php echo $this->title; ?></h5>
                    </div>
                </div>
                <div class="questions-wrapper">
                    <?php if( !empty( $this->text ) ) : ?>
                        <p><?php echo $this->text; ?></p>
                    <?php endif; ?>
                    <?php if( !empty( $this->faq ) ) : ?>
                        <div class="questions-wrapper__list">
                            <?php foreach( $this->faq as $item ) : ?>
                                <?php if( !empty( $item['question'] ) and !empty( $item['answer'] ) ) : ?>
                                    <div class="questions-wrapper__one">
                                        <h2><?php echo $item['question']; ?></h2>
                                        <p><?php echo $item['answer']; ?></p>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <?php
    }
}