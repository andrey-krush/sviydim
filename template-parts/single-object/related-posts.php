<?php 

class Single_Object_Related_Posts {

    public function __construct() {

        $this->settlement_name = get_post_meta(get_the_ID(), 'settlement_name')[0];
        $this->region_name = get_post_meta(get_the_ID(), 'region_name')[0];
        $this->area_name = get_post_meta(get_the_ID(), 'area_name')[0];

        $args = array(
            'post_type' => 'object',
            'post_status' => 'publish',
            'posts_per_page' => 4,
            'post__not_in' => array(get_the_ID()),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'settlement_name',
                    'value' => $this->settlement_name
                ),
                array(
                    'key' => 'region_name',
                    'value' => $this->region_name
                ),
                array(
                    'key' => 'area_name',
                    'value' => $this->area_name
                ),
            )
        );

        $this->query = new WP_Query($args);
    }   

    public function render() {
        ?>
        <?php if( $this->query->have_posts() ) : ?>
            <section class="main-history" style="background: #F1F3F4">
                <div class="container">
                    <div class="main-history__wrapper">
                    <div class="history-title">
                        <h3>Інші об’єкти у м. <?php echo $this->settlement_name; ?></h3>
                    </div>
                    <div class="slider-history swiper slider-3 last-add-wrapper-swiper" id="slider-3">
                        <div class=" slider-history__wrapper swiper-wrapper last-add-wrapper">
                            <?php while ( $this->query->have_posts() ) : $this->query->the_post(); ?>

                                <div class="slider-history__slide swiper-slide ">
                                    <a href="<?php echo get_the_permalink(); ?>" class="list-cards__card ">
                                    <?php $post_thumbnail = get_the_post_thumbnail_url(); ?>
                                    <?php if( !empty( $post_thumbnail ) ) : ?>
                                        <div class="card-img">
                                            <img src="<?php echo $post_thumbnail; ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <?php $object_type = get_terms(array(
                                        'taxonomy' => 'object_type',
                                        'object_ids' => array( get_the_ID() )
                                    ))[0]; ?>
                                    <div class="card-info">
                                        <?php if( !empty( $object_type ) ) : ?>
                                                <?php $object_type_icon = get_field('category_icon', 'object_type_' . $object_type->term_id ); ?>
                                                <?php if( !empty( $object_type_icon ) ) : ?>
                                                    <div class="icon">
                                                        <img src="<?php echo $object_type_icon; ?>" />
                                                    </div>
                                                <?php endif; ?>
                                            <p><?php echo $object_type->name; ?></p>
                                        <?php endif; ?>
                                        <h3><?php echo get_the_title(); ?> </h3>
                                    </div>
                                    </a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div class="swiper-pagination slider-3__swiper-pagination"></div>
                    </div>
                    <!-- <div class="history-button">
                        <a href="#" class="button-secondary">
                        <p class="text-button-bold">показати ще</p>
                        </a>
                    </div> -->
                    </div>
                </div>
            </section>
        <?php endif; ?>
        <?php 
    }
}