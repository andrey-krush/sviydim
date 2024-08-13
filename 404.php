<?php get_header(); ?>
<main>
    <section class="error">
        <div class="container">
            <div class="error__block">
                <h2>помилка</h2>
                <div class="error__img img">
                     <img src="<?=TEMPLATE_PATH?>/static/app/img/404.svg">
                </div>
                <h2>сторінку не знайдено</h2>
                <button class="error__button">повернутись назад</button>
            </div>
        </div>
    </section>
</main>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery-3.6.0.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery.fancybox.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/jquery-ui.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/datepicker_uk.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/swiper.min.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/app.js"></script>
    <script src="<?=TEMPLATE_PATH?>/scripts/apiServer.js"></script>