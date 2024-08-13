<?php

class Front_Page_Base_Damage {
    
    public function __construct() {
        $query = new WP_Query(array(
            'post_type' => 'object',
            'post_status' => 'publish',
        ));

        $this->object_count = $query->found_posts;

        $query = new WP_Query(array(
            'post_type' => 'object',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'object_type',
                    'field' => 'slug',
                    'terms' => array( 'house' )
                )
            )
        ));

        $this->residential_objects_count = $query->found_posts;

        $query = new WP_Query(array(
            'post_type' => 'object',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'object_type',
                    'field' => 'slug',
                    'terms' => array( 'institutions' )
                )
            )
        ));

        $this->commercial_objects_count = $query->found_posts;

        $base_damage_section = get_field('base_damage_section');
        $this->title = $base_damage_section['title'];
        $this->subtitle = $base_damage_section['subtitle'];
        $this->mobile_title = $base_damage_section['mobile_title'];
    }

    public function render() {
        ?>

        <section class="main-base-build-damages">
            <div class="container">
                <div class="main-base-build-damages__wrapper">
                <div class="base-build-damages-info">
                    <div class="base-build-damages-info__text">
                        <?php if( !wp_is_mobile() ) : ?>
                            <h2 class="desc"><?php echo $this->title; ?></h2>
                        <?php else : ?>
                            <h2 class="mobile"><?php echo $this->mobile_title; ?></h2>
                        <?php endif; ?>
                        <?php if( !empty( $this->subtitle ) ) : ?>
                            <p><?php echo $this->subtitle; ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="base-build-damages-info__numbers">
                    <div class="count-objects">
                        <p class="count-objects__title"></p>
                        <div><span class="count">
                            <p class="count-objects__title"><?php echo $this->object_count; ?></p>
                        </span></div>
                        <p>загальна кількість об’єктів</p>
                    </div>
                    <div class="count-objects">
                        <div><span class="count">
                            <p class="count-objects__title"><?php echo $this->residential_objects_count; ?></p>
                        </span></div>
                        <p>житлових</p>
                    </div>
                    <div class="count-objects">
                        <div><span class="count">
                            <p class="count-objects__title"><?php echo $this->commercial_objects_count; ?></p>
                        </span></div>
                        <p>закладів</p>
                    </div>
                    </div>
                </div>
                <div class="base-build-damages-find select">
                    <h3>Шукати об’єкт</h3>
                    <div class="base-build-damages-find__wrapper">
                    <select class="select2-main" name="state" data-placeholder="введіть назву міста ">
                        <option></option>
                    </select>
                    <div class="main-search-base button-primary">
                        <a href="#" class="text-button-bold">шукати</a>
                    </div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <?php
    }

}