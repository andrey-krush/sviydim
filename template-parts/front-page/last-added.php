<?php 

class Front_Page_Last_Added {

    public function __construct () {

        $query = new WP_Query(array(
            'post_type' => 'object',
            'posts_per_page' => 8,
            'post_status' => 'publish'
        ));

        $this->posts = $query->posts;
    }

    public function render() {

        if( !empty( $this->posts ) ) : ?>
            <section class="main-history">
                <div class="container">
                    <div class="main-history__wrapper">
                        <div class="history-title">
                            <h2>Останні додані</h2>
                            <a href="<?php echo get_post_type_archive_link('object'); ?>">
                                <p>всі матеріали</p>
                            </a>
                        </div>
                        <div class="slider-history swiper slider-3 last-add-wrapper-swiper" id="slider-3">
                            <div class=" slider-history__wrapper swiper-wrapper last-add-wrapper">
                                <?php foreach( $this->posts as $item ) : ?>
                                    <div class="slider-history__slide swiper-slide ">
                                        <a href="<?php echo get_the_permalink($item->ID); ?>" class="list-cards__card ">
                                            <?php $post_thumbnail = get_the_post_thumbnail_url($item->ID); ?>
                                            <?php if( !empty( $post_thumbnail ) ) : ?>
                                                <div class="card-img">
                                                    <img src="<?php echo $post_thumbnail; ?>" />
                                                </div>
                                            <?php endif; ?>
                                            <?php $object_type = get_terms(array(
                                                'taxonomy' => 'object_type',
                                                'object_ids' => array( $item->ID)
                                            ))[0]; ?>
                                            <div class="card-info">
                                                <?php if( !empty( $object_type ) ) : ?>
                                                        <?php $object_type_icon = get_field('category_icon', 'object_type_' . $object_type->term_id); ?>
                                                        <?php if( !empty( $object_type_icon ) ) : ?>
                                                            <div class="icon">
                                                                <img src="<?php echo $object_type_icon; ?>" />
                                                            </div>
                                                        <?php endif; ?>
                                                    <p><?php echo $object_type->name; ?></p>
                                                <?php endif; ?>
                                                <h3><?php echo get_the_title($item->ID); ?> </h3>
                                            </div>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <div class="swiper-pagination slider-3__swiper-pagination"></div>
                        </div>
                        <div class="history-button">
                            <a href="https://dev.sviydim.sheep.fish/object/" class="button-primary button-secondary">
                                <p class="text-button-bold">всі матеріали</p>
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif;
    }
}