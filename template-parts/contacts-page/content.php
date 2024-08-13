<?php

class Contacts_Page_Content {

    public function __construct() {
        $this->title = get_the_title();
        $content = get_field('content');
        $this->main_image = $content['main_image'];
        $this->text = $content['text'];
        $this->address = $content['address'];
        $this->mails = $content['mails'];
        $this->phone_numbers = $content['phone_numbers'];
        $this->main_page_link = get_the_permalink(get_option('page_on_front'));
    }

    public function render() {
        ?>

        <section class="contacts">
            <div class="container">
                <div class="contacts-header">
                    <h1><?php echo $this->title; ?></h1>
                    <div class="navigator">
                        <h5><a href="<?php echo $this->main_page_link; ?>">головна</a> / <?php echo $this->title; ?></h5>
                    </div>
                </div>
                <div class="contacts-wrapper">
                    <?php if( !empty( $this->main_image ) ) :  ?>
                        <div class="contacts-wrapper__img">
                            <img src="<?php echo $this->main_image; ?>" />
                        </div>
                    <?php endif; ?>
                    <div class="contacts-wrapper__info">
                        <?php if( !empty( $this->text ) ) : ?>
                            <p><?php echo $this->text; ?></p>
                        <?php endif; ?>
                        <?php if( !empty( $this->address ) ) : ?>
                            <div class="address">
                                <h2>Адреса:</h2>
                                <p><?php echo $this->address; ?></p>
                            </div>
                        <?php endif; ?>
                        <?php if( !empty( $this->mails ) or !empty( $this->phone_numbers ) ) : ?>
                            <div class="contact">
                                <h2>Контакти:</h2>
                                <?php if( !empty( $this->mails ) ) : ?>
                                    <?php foreach( $this->mails as $item ) : ?>
                                        <a href="mailto:hey.abo.media@gmail.com"><?php echo $item['mail']; ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <?php if( !empty( $this->phone_numbers ) ) : ?>
                                    <?php foreach( $this->phone_numbers as $item ) : ?>
                                        <a href='tel:<?php echo $item['number']; ?>'><?php echo $item['number']; ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}