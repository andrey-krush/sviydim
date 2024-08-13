<?php

class Taxonomy_Tag_Sidebar_Section {

    public function __construct() {

        global $wpdb;

        $this->areas = $wpdb->get_results( "SELECT * FROM wp_areas ORDER BY name");

        $this->term = get_queried_object();
        $this->term_link = get_term_link($this->term, 'building_tag');
        $this->term_name = $this->term->name;

        $this->main_page_link = get_the_permalink(get_option('page_on_front'));

        $this->building_types = get_terms(array(
            'taxonomy' => 'building_type',
            'hide_empty' => true
        ));

        $this->top_posts = get_field('top_posts', 'building_tag_' . $this->term->term_id );
        $this->form_title = get_field('form_title', 'building_tag_' . $this->term->term_id );
        $this->form_button = get_field('form_button', 'building_tag_' . $this->term->term_id );

    }

    public function render() {
        ?>

        <section class="rebuild">
        <div class="container">
        <div class="rebuild-header">
            <h1><?php echo $this->term_name; ?></h1>
            <div class="navigator">
                <h5><a href="<?php echo $this->main_page_link; ?>">головна</a> <span>/</span> <?php echo $this->term_name; ?></h5>
            </div>
        </div>
        <div class="rebuild__wrapper">
        <div class="sidebar">
            <form id="base-dameges" class="form-objects" data-page_link ="<?php echo $this->term_link; ?>">
                <div class="base-title">
                    <h3>Знайти історію</h3>
                </div>
                <div class="form-objects__inputs">
                    <div class="form-objects__inputs-wrapper">
                        <div class="base-select vw-26">
                            <label for="select-area">
                                <p>Область</p>
                            </label>
                            <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                            <select class="select2-base-damages" id="select-area" name="area" data-placeholder="введіть назву області">
                                <option></option>
                                <?php foreach( $this->areas as $item ) : ?>
                                    <option value="<?php echo $item->ID; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="base-select vw-25">
                            <label for="select-region">
                                <p>Район</p>
                            </label>
                            <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                            <select class="select2-base-damages" id="select-region" name="region" data-placeholder="введіть назву району">
                                <option></option>
                            </select>
                        </div>
                        <div class="base-select vw-26">
                            <label for="select-settlement">
                                <p>Населений пункт</p>
                            </label>
                            <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                            <select class="select2-base-damages" id="select-settlement" name="settlement" data-placeholder="введіть назву міста">
                                <option></option>
                            </select>
                        </div>
                        <div class="base-select vw-25">
                            <label for="select-street">
                                <p>Вулиця</p>
                            </label>
                            <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                            <select class="select2-base-damages" id="select-street" name="street" data-placeholder="введіть назву вулиця">
                                <option></option>
                            </select>
                        </div>
                        <div class="base-select vw-9">
                            <label for="select-number-home">
                                <p>№ будинку</p>
                            </label>
                            <input type="text" id="select-number-home" name="number"/>
                        </div>
                    </div>
                    <div class="form-objects__inputs-wrapper">
                        <div class="base-select vw-30">
                            <label for="select-type">
                                <p>Тип будови</p>
                            </label>
                            <span class="clear-select-filter">
                                            <svg>
                                                <use xlink:href="#app__x"></use>
                                            </svg>
                                        </span>
                            <select class="select2-base-damages" id="select-type" name="build_type" data-placeholder="всі типи будови">
                                <option></option>
                                <?php foreach( $this->building_types as $item ) : ?>
                                    <option value="<?php echo $item->slug; ?>"><?php echo $item->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <label for="datepicker1">
                            <p>Ймовірний період руйнування</p>
                        </label>
                        <div class="base-datapicker">
                            <div class="base-datapicker_one">
                                <input type="text" readonly id="datepicker1" name="start_date" class="calendar" placeholder="з">
                            </div>
                            <div class="base-datapicker_one">
                                <input type="text" readonly id="datepicker2" name="end_date" class="calendar" placeholder="до">
                            </div>
                        </div>
                    </div>
                    <div class="form-objects__inputs-button">
                        <button class="button-primary button-base-dameges text-button-bold">
                            <h4>застосувати</h4>
                        </button>
                    </div>
                </div>
            </form>
            <?php if( !empty( $this->top_posts ) ) : ?>
                <div class="sidebar-top">
                    <h3>Топ статей</h3>
                    <div class="sidebar-top__list">
                        <?php foreach( $this->top_posts as $item ) : ?>
                            <a href="<?php echo get_the_permalink($item); ?>">
                                <p><?php echo get_the_title($item); ?></p>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( !empty( $this->form_title ) and !empty( $this->form_button ) ) : ?>
                <div class="sidebar-memories">
                    <h3><?php echo $this->form_title; ?></h3>
                    <a href="<?php echo $this->form_button['url']; ?>" class="text-button-bold button-primary button-memory"><?php echo $this->form_button['title']; ?></a>
                </div>
            <?php endif; ?>
        </div>

        <?php
    }

}