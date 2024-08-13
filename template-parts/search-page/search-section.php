<?php

class Search_Page_Search_Section {

    public function __construct() {

        $args = array(
            'posts_per_page' => 12,
            's' => $_GET['search'],
        );

    
        if( $_GET['filter'] == 'object' ) : 

            $args['post_type'] = array('object');
        
        elseif( $_GET['filter'] == 'help' or $_GET['filter'] == 'rebuilt' or $_GET['filter'] == 'stories' ) :

            $args['post_type'] = array('building');
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'story_type',
                    'field' => 'slug',
                    'terms' => array( $_GET['filter'] )
                )
            );

        else :

            $args['post_type'] = array('building', 'object');

        endif;            

        $this->paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1; 
        $args['paged'] = $this->paged;

        $this->query = new WP_Query($args); 
        

        $this->base_damage_link = get_post_type_archive_link( 'object' );
    }

    public function render() {
        ?>

        <?php if( $this->query->have_posts() ) : ?>
            <section class="main-search">
                <div class="container">
                    <div class="main-search__wrapper">
                        <div class="main-search-title">
                            <h2>Знайшлось <?php echo $this->query->found_posts; ?> матеріалів:</h2>
                        </div>
                    <div class="main-search-result">
                        <div class="main-search-filter">
                        <div class="main-search-filter__one" data-name="">
<!--                             <h3>12</h3> -->
                            <p>всі матеріали</p>
                        </div>
                        <div class="main-search-filter__one" data-name="object">
                            <!-- <h3>6</h3> -->
                            <p>база зруйнованого </p>
                        </div>
                        <div class="main-search-filter__one" data-name="stories">
                            <!-- <h3>3</h3> -->
                            <p>історії</p>
                        </div>
                        <div class="main-search-filter__one" data-name="rebuilt">
                            <!-- <h3>2</h3> -->
                            <p>відбудовано</p>
                        </div>
                        <div class="main-search-filter__one" data-name="help">
                            <!-- <h3>1</h3> -->
                            <p>допомога</p>
                        </div>
                        </div>
                        <div class="filter-big text-button-slim">
                        <svg>
                            <use xlink:href="#app__filter"></use>
                        </svg> фільтр
                        </div>
                        <div class="main-search-cards">
                        <?php while( $this->query->have_posts() ) : $this->query->the_post(); ?>
                            <a href="<?php echo get_the_permalink(); ?>" class="card-horizontal">
                                <div class="card-horizontal__wrapper">
                                    <?php $post_thumbnail = get_the_post_thumbnail_url(); ?>
                                    <?php if( !empty( $post_thumbnail ) ) : ?>
                                        <div class="card-horizontal__img">
                                            <img src="<?php echo $post_thumbnail; ?>" />
                                        </div>
                                    <?php endif; ?>
                                    <div class="card-horizontal__info">
                                        <?php if( 'object' == get_post_type( get_the_ID() ) ) : ?>
                                            <h5>база зруйнованого</h5>
                                        <?php else : ?>
                                            <?php $story_type = get_terms( array(
                                                'taxonomy' => 'story_type',
                                                'object_ids' => array( get_the_ID() )
                                            ) )[0]; ?>
                                            <?php if( !empty( $story_type ) ) : ?>
                                                <h5><?php echo $story_type->name; ?></h5>
                                            <?php endif; ?>
                                        <?php endif;?>
                                        <p><?php echo get_the_title(); ?></p>
                                        <h5><?php echo get_post_meta(get_the_ID(), 'settlement_name')[0]; ?>, <?php echo get_post_meta(get_the_ID(), 'area_name')[0]; ?></h5>
                                    </div>
                                </div>
                            </a>
                        <?php endwhile; ?>
                            <div class="help-pagination">
                                <?php echo paginate_links(array(
                                            'total' => $this->query->max_num_pages,
                                            'current' => $this->paged,
                                            'prev_text' => '<svg width="6" height="12" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 13L7 7L1 1" stroke="#465558" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>',
                                            'next_text' => '<svg width="6" height="12" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M1 13L7 7L1 1" stroke="#465558" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>',
                                            'end_size' => 1,
                                            'mid_size' => 1,
                                        )); ?>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="modal" id="modal-history">
                    <div class="modal-bg"></div>
                    <div class="modal__wrapper">
                        <div class="main-search-filter__mobile">
                        <form class="filter-form" id="filter-form">
                            <label class="radio-container">
                                <p>всі матеріали</p>
                                <input type="radio" checked="checked" name="filter" value="">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">
                                <p>база зруйнованого</p>
                                <input type="radio" name="filter" value="object">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">
                                <p>історії</p>
                                <input type="radio" name="filter" value="stories">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">
                                <p>відбудовано</p>
                                <input type="radio" name="filter" value="rebuilt">
                                <span class="checkmark"></span>
                            </label>
                            <label class="radio-container">
                                <p>допомога</p>
                                <input type="radio" name="filter" value="help">
                                <span class="checkmark"></span>
                            </label>
                            <button class="button-primary button-search1 text-button-bold">
                            <h4>застосувати</h4>
                            </button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
            </section>
        <?php else : ?>
            <section class="main-search">
                <div class="container">
                    <div class="main-search__wrapper">
                        <div class="main-search-title">
                            <h2>Ми не знайшли матеріалів за цим запитом</h2>
                        </div>
                        <div class="main-search-input">
                            <h3 class="main-search-input__label">Змінити запит:</h3>
                            <div class="main-search-input__new">
                            <h3 class="label-input-search">Змінити запит:</h3>
                            <div class="main-search-input__new-wrapper">
                                <svg>
                                <use xlink:href="#app__icon_search"></use>
                                </svg>
                                <input type="search" id="search-main2" placeholder="шукати" />
                            </div>
                            <a href="#" class="button-three text-button-bold button-search-main"> шукати </a>
                            </div>
                            <h3>Також ви можете скористатися фільтрами для пошуку об'єктів у <a href="<?php echo $this->base_damage_link; ?>">Базі зруйнованого</a></h3>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php wp_reset_query();
    }

}