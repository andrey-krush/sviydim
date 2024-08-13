<?php 

class Single_Building_Related_Posts {

    public function __construct() {

        $this->settlement_name = get_post_meta(get_the_ID(), 'settlement_name')[0];
        $this->region_name = get_post_meta(get_the_ID(), 'region_name')[0];
        $this->area_name = get_post_meta(get_the_ID(), 'area_name')[0];
        $this->street = get_post_meta(get_the_ID(), 'street')[0];
        $this->building_number = get_post_meta(get_the_ID(), 'building_number')[0];

        $args = array(
            'post_type' => 'building',
            'post_status' => 'publish',
            'posts_per_page' => 8,
            'post__not_in' => array(get_the_ID()),
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'post_info_recommended_post',
                    'value' => '1'
                ),
            )
        );

        $this->query = new WP_Query($args);
        $this->posts = $this->query->posts;
        $this->big_posts = array_slice( $this->posts, 0, 2 );
        $this->small_posts = array_slice( $this->posts, 2, 8 );
    }

    public function render() {
        ?>
        <?php if( !empty( $this->posts ) ) : ?>
            <section class="recomended-read">
                <div class="container">
                    <div class="recomended-read__wrapper">
                    <h2>Рекомендуємо прочитати</h2>
                        <?php foreach( $this->big_posts as $item ) : ?>
                            <div href="<?php echo get_the_permalink($item->ID); ?>" class="card-big">
                                <div class="card-big__img">
                                    <img src="<?php echo get_the_post_thumbnail_url($item->ID); ?>" />
                                </div>
                                <?php 
                                    $build_type = get_terms(array(
                                        'taxonomy' => 'building_type',
                                        'hide_empty' => true,
                                        'childless' => true,
                                        'object_ids' => array( $item->ID )
                                    ))[0]; 
                                ?>
                                    
                                <div class="card-big__info">
                                    <?php if( !empty( $build_type ) ) : ?>
                                    <?php $build_type_icon = get_field('category_icon', 'building_type_' . $build_type->term_id); ?>
                                        <div class="card-info">
                                            <?php if( !empty( $build_type_icon ) ) : ?>
                                                <div class="icon">
                                                    <img src="<?php echo $build_type_icon; ?>" />
                                                </div>
                                            <?php endif; ?>
                                            <p><?php echo $build_type->name; ?></p>
                                        </div>
                                    <?php endif; ?>
                                    <h2><?php echo get_the_title( $item->ID ); ?></h2>
                                    <h4><?php echo get_the_excerpt( $item->ID ); ?></h4>
                                    <a href="<?php echo get_the_permalink($item->ID); ?>" target="_blank" class="text-button-bold button-primary">читати історію</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php if( !empty( $this->small_posts ) ) : ?>
                            <div class="card-small_wrapper">
                                <?php foreach( $this->small_posts as $item ) : ?>
                                    <a href="<?php echo get_the_permalink($item->ID); ?>" class="card-small">
                                    <?php 
                                        $build_type = get_terms(array(
                                            'taxonomy' => 'building_type',
                                            'hide_empty' => true,
                                            'childless' => true,
                                            'object_ids' => array( $item->ID )
                                        ))[0]; 
                                    ?>
                                        <div class="card-small__img">
                                            <img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>" />
                                        </div>
                                        <div class="card-small__info">
                                            <?php if( !empty( $build_type ) ) : ?>
                                                <h5><?php echo $build_type->name; ?></h5>
                                            <?php endif; ?>
                                            <p><?php echo get_the_title( $item->ID); ?></p>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="recomended-read__wrapper-mobile">
                        <h3>Рекомендуємо прочитати</h3>
                        <?php foreach( $this->posts as $item ) : ?>
                            <a href="<?php echo get_the_permalink($item->ID); ?>" class="list-cards__card ">
                                <div class="card-img">
                                <img src="<?php echo get_the_post_thumbnail_url( $item->ID ); ?>">
                                </div>
                                <?php 
                                    $build_type = get_terms(array(
                                        'taxonomy' => 'building_type',
                                        'hide_empty' => true,
                                        'childless' => true,
                                        'object_ids' => array( $item->ID )
                                    ))[0]; 
                                ?>
                                <div class="card-info">
                                <?php if( !empty( $build_type ) ) : ?>
                                    <?php $build_type_icon = get_field('category_icon', 'building_type_' . $build_type->term_id); ?>
                                    <?php if( !empty( $build_type_icon ) ) : ?>
                                        <div class="icon">
                                            <img src="<?php echo $build_type_icon; ?>">
                                        </div>
                                    <?php endif; ?>
                                    <p><?php echo $build_type->name; ?></p>
                                <?php endif; ?>
                                <h3><?php echo get_the_title($item->ID); ?></h3>
                                </div>
                            </a>
                        <?php endforeach; ?>
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