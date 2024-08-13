"use strict";
/* ============================ apiServer START ================================================================= */
console.log('apiServer');


/* ============================ dynamic_adapt END ================================================================= */


let $ = jQuery;
let result;
let ajax1Returned = false;
let ajax2Returned = false;
let ajax3Returned = false;
$(document).ready(function () {

    searchMain()
    initSliderHistory();
    dropMenu();

    burgerMenu();
    SliderMain();

    Select2();
    DatePublish();
    datepickerInit()

    AnimatedText();
    changeUrlOnScroll();
    goBack();
    MobileVersion()

    initGallery();
    Popup();
    SendForm();
    SendGlobalFilter();
    CopyLinkFunc();
    ClearOneSelect();
    checkIconOnArticle();

    checkURLPage();
    if(window.location.pathname === '/wp-admin/post.php' || window.location.pathname === '/wp-admin/post-new.php' ){
        getFilterRay1();
        getFilterSettl1();
        getFilterStreet1();
    }
    else {
        getFilterRay();
        getFilterSettl();
        getFilterStreet2();
    }
    if(post_place_info !== 'null' && post_place_info !== ''){
        $('.count-posts').show()
        result = JSON.parse(post_place_info);
        console.log(result)
        startAjaxFilter()
    }
    else {
         ajax1Returned = true;
         ajax2Returned = true;
         ajax3Returned = true;
        $('.count-posts').hide()
    }
    if(window.location.pathname === "/story_type/rebuilt/"){
        changePositionCalendar();
    }
     changeFilterAfterReload()
    console.log(window.location)
});
function checkIconOnArticle(){
    if($('.base-damages-one-post__main .swiper').length > 0){
        if($('.base-damages-one-post__main .swiper .swiper-wrapper .swiper-slide').length === 0) {
            $('.article-info .card-info').css('top', 0)
        }
    }
    if($('.article .swiper').length > 0) {
        if ($('.article .swiper .swiper-wrapper .swiper-slide').length === 0) {
            $('.article-info .card-info').css('top', 0)
        }
    }
}
function ClearOneSelect(){
    $(document).on('click','.clear-select-filter',function () {
        let select = $(this).closest('.base-select').find('select').attr('name');
        if(select === 'area'){
            $('select[name=area] option').prop('selected',false);
            $('select[name=region] option').remove()
            $('select[name=settlement] option').remove()
            $('select[name=street] option').remove()
            $('select[name=settlement]').prepend(`<option></option>`)
            $('select[name=street]').prepend(`<option></option>`)
            $('select[name=region]').prepend(`<option></option>`)
            $('select[name=area]').prepend(`<option></option>`)
            $('select[name=area] option').eq(0).prop('selected',true);
        }
        if(select === 'region'){
            $('select[name=region] option').prop('selected',false);
            $('select[name=settlement] option').remove()
            $('select[name=street] option').remove()
            $('select[name=settlement]').prepend(`<option></option>`)
            $('select[name=street]').prepend(`<option></option>`)
            $('select[name=region]').prepend(`<option></option>`)
            $('select[name=region] option').eq(0).prop('selected',true);
        }
        if(select === 'settlement'){
            $('select[name=settlement] option').prop('selected',false);
            $('select[name=street] option').remove()
            $('select[name=street]').prepend(`<option></option>`)
            $('select[name=settlement]').prepend(`<option></option>`)
            $('select[name=settlement] option').eq(0).prop('selected',true);
        }
        if(select === 'street'){
            $('select[name=street] option').prop('selected',false);
            $('select[name=street]').prepend(`<option></option>`)
            $('select[name=street] option').eq(0).prop('selected',true);
        }
        if(select === 'build_type'){
            $('select[name=build_type] option').prop('selected',false);
            $('select[name=build_type]').prepend(`<option></option>`)
            $('select[name=build_type] option').eq(0).prop('selected',true);
        }
        changeSelect2Base();
    })

}
function checkURLPage(){
    var url;
    if($('#base-dameges').data('page_link')){
        url = new URL($('#base-dameges').data('page_link')).pathname;
        let check = getCookie('removePage')
        setCookie('removePage','false')
       if(window.location.pathname.indexOf('page') !== -1 && check==='true'){
           window.location.pathname = url;
       }
    }
    
}

function startAjaxFilter(){
    if(result.area_id)ajaxGetArea({area:result.area_id});
    else ajax1Returned = true;
    if(result.region_id)ajaxGetSettlement({region:result.region_id});
    else ajax2Returned = true;
    if(result.settlement_id)ajaxGetStreet({settlement:result.settlement_id})
    else ajax3Returned = true;
}
function changeFilterAfterReload(){
    console.log(ajax1Returned,ajax2Returned,ajax3Returned);
    if (ajax1Returned && ajax2Returned && ajax3Returned && post_place_info !== 'null' && post_place_info !== '') {

        if(window.location.pathname === '/wp-admin/post.php' || window.location.pathname === '/wp-admin/post-new.php' ){
            if (result.area_id)$('select[name=area]').find(`option[data-id='${result.area_id}']`).prop('selected', true);
            if (result.region_id) $('select[name=region]').find(`option[data-id=${result.region_id}]`).prop('selected', true);
            if (result.settlement_id) $('select[name=settlement]').find(`option[data-id=${result.settlement_id}]`).prop('selected', true);
        }
        else{
            if (result.area_id)$('select[name=area]').find(`option[value="${result.area_id}"]`).prop('selected', true);
            if (result.region_id) $('select[name=region]').find(`option[value=${result.region_id}]`).prop('selected', true);
            if (result.settlement_id) $('select[name=settlement]').find(`option[value=${result.settlement_id}]`).prop('selected', true);
        }
        if (result.street) $('select[name=street]').find(`option[value="${result.street}"]`).prop('selected', true);

        if (result.building_number)$('input[name=number]').val(result.building_number)
        if (result.build_type)$('select[name=build_type]').find(`option[value="${result.build_type}"]`).prop('selected', true);
        if (result.start_date){
            $('input[name=start_date]').val(result.start_date)
            $('#datepicker1').addClass('active')
        }
        if (result.end_date){
            $('input[name=end_date]').val(result.end_date)
            $('#datepicker2').addClass('active')
        }
        $('.select2-base-damages').select2({
            tags: true
        });
        changeSelect2Base()
    }
}
function changePositionCalendar(){
    $('#ui-datepicker-div').addClass('changePosition')
}

function changeSelect2Base(){
    $('.select2-base-damages').each(function (){
        if($(this)[0].value === ""){
            $(this).closest('.base-select').find('.select2.select2-container .select2-selection').css('background-color','#fff')
            $(this).closest('.base-select').find('.select2.select2-container .select2-selection').css('border','1px solid #DEE3E7')
        }
        else{
            $(this).closest('.base-select').find('.select2.select2-container .select2-selection').css('background-color','#E2F3EF')
            $(this).closest('.base-select').find('.select2.select2-container .select2-selection').css('border','1px solid #465558')
        }
    })
}
function getFilterRay(){
    $(document).on('change','select[name=area]',function (){
        $('select[name=region] option').remove()
        $('select[name=region]').val()
        $('select[name=settlement] option').remove()
        $('select[name=street] option').remove()
        $('select[name=settlement]').prepend(`<option></option>`)
        $('select[name=street]').prepend(`<option></option>`)
        $('select[name=region]').prepend(`<option></option>`)
        changeSelect2Base();
        let area = $(this).val();
        ajaxGetArea({area:area});
    })
}
function getFilterRay1(){
    $(document).on('change','select[name=area]',function (){
        $('select[name=region] option').remove()
        $('select[name=region]').val()
        $('select[name=settlement] option').remove()
        $('select[name=street] option').remove()
        $('select[name=settlement]').prepend(`<option></option>`)
        $('select[name=street]').prepend(`<option></option>`)
        $('select[name=region]').prepend(`<option></option>`)
        changeSelect2Base();
        let name_area = $(this).val();
        let area = $(this).find(`option[value="${name_area}"]`).data('id');
        ajaxGetArea({area:area});
    })
}
function fillSelectRay(regions){
    $.each(regions, function (key, value) {
        $('select[name=region]').append(`<option value=${value.ID}>${value.Name}</option>`);
    });
}
function fillSelectRay1(regions){
    $.each(regions, function (key, value) {
        $('select[name=region]').append(`<option data-id=${value.ID} value="${value.Name}">${value.Name}</option>`);
    });
}
function getFilterSettl(){
    $(document).on('change','select[name=region]',function (){
        $('select[name=settlement] option').remove()
        $('select[name=street] option').remove()
        $('select[name=settlement]').prepend(`<option></option>`)
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();

        let region = $(this).val();
        ajaxGetSettlement({region:region});
    })

    $(document).on('change','select[name=settlement]',function (){
        $('select[name=street] option').remove()
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();
    })
    $(document).on('change','select[name=street]',function () {
        changeSelect2Base();
    })
}
function getFilterSettl1(){
    $(document).on('change','select[name=region]',function (){
        $('select[name=settlement] option').remove()
        $('select[name=street] option').remove()
        $('select[name=settlement]').prepend(`<option></option>`)
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();

        let name_region = $(this).val();
        let region = $(this).find(`option[value="${name_region}"]`).data('id');
        ajaxGetSettlement({region:region});
    })

    $(document).on('change','select[name=settlement]',function (){
        $('select[name=street] option').remove()
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();
    })
    $(document).on('change','select[name=street]',function () {
        changeSelect2Base();
    })
}
function fillSelectSettl(settl){
    $.each(settl, function (key, value) {
        $('select[name=settlement]').append(`<option value=${value.ID} data-ref=${value.Ref}>${value.Name}</option>`);
    });
}
function fillSelectSettl1(settl){
    $.each(settl, function (key, value) {
        $('select[name=settlement]').append(`<option value="${value.Name}" data-id=${value.ID} data-ref=${value.Ref}>${value.Name}</option>`);
    });
}
function getFilterStreet1(){
    $(document).on('change','select[name=settlement]',function (){
        $('select[name=street] option').remove()
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();
        let name_settlement = $(this).val();
        let settlement = $(this).find(`option[value="${name_settlement}"]`).data('id');

        ajaxGetStreet({settlement:settlement});
    })
}
function getFilterStreet2(){
    $(document).on('change','select[name=settlement]',function (){
        $('select[name=street] option').remove()
        $('select[name=street]').prepend(`<option></option>`)
        changeSelect2Base();
        let settlement = $(this).val();
        console.log(settlement)
        ajaxGetStreet({settlement:settlement});
    })
}
function fillSelectStreet(street){
    $.each(street, function (key, value) {
        $('select[name=street]').append(`<option value="${value.Name}" data-id=${value.ID}>${value.Name}</option>`);
    });
}

function Popup(){

    $(document).on('click','.filter-big', function () {
        $('.modal').addClass('show');
        $('body').addClass('no-scroll');
        $('.sidebar form').appendTo('.modal__wrapper');

    })
    $(document).on('click','.modal-bg',function () {
        $('.modal').removeClass('show');
        $('body').removeClass('no-scroll');
    });
}
function datepickerInit () {
    $("#datepicker1").datepicker({
        showOn: "button",

        buttonImage: "https://i.ibb.co/gdYktRk/calendar.png",
        altField: "#alternate",
        altFormat: "DD, d.MM",
        autoSize: true,
        maxDate: 0,
        changeMonth: true,
        changeYear: true,

        onSelect: function (dateText) {
           $('#datepicker1').css('background','#E2F3EF');
           $('#datepicker1').css('border','1px solid #465558')
            // let selectedDate = Number(dateText.substr(6, 4)) + '/' + Number(dateText.substr(3, 2)) + '/' +  Number(dateText.substr(0, 2))+ '/';
            // window.location.pathname = selectedDate;
        },
    });
    $("#datepicker2").datepicker({
        showOn: "button",
        buttonImage: "https://i.ibb.co/gdYktRk/calendar.png",
        altField: "#alternate",
        altFormat: "DD, d.MM",
        autoSize: true,
        maxDate: 0,
        changeMonth: true,
        changeYear: true,

        onSelect: function (dateText) {
            $('#datepicker2').css('background','#E2F3EF')
            $('#datepicker2').css('border','1px solid #465558')
            // let selectedDate = Number(dateText.substr(6, 4)) + '/' + Number(dateText.substr(3, 2)) + '/' +  Number(dateText.substr(0, 2))+ '/';
            // window.location.pathname = selectedDate;
        },
    });
}
let arrowStatus='up';
function DatePublish(){
    let sortMethod = getURLParameter('sort_type');
    $('select[name=date-publish]').find(`option[value=${sortMethod}]`).prop('selected', true)
    $('.select2-data-publich').select2({
        minimumResultsForSearch: Infinity,
        tags: true,
    });
    if(sortMethod !== undefined)$('.date-publish').find('.select2.select2-container .select2-selection').addClass('border-click')

    $(document).on('click','.date-publish-button',function () {
        $('.date-publish-button').removeClass('active');
        $(this).addClass('active');
        let id = $(this).attr('id')
        let strId = id.substr(id.length - 2, 2);
        let sort = $('select[name=date-publish]').val();
        if( strId === 'wn')arrowStatus = 'down';
        else arrowStatus = 'up';
        HistoryPushState('sort_lay', arrowStatus)
        HistoryPushState('sort_type', sort)
    });
    $(document).on('change', 'select[name=date-publish]', function(e) {
        let sort = $('select[name=date-publish]').val();
        arrowStatus = getURLParameter('sort_lay');
        if(arrowStatus === undefined)arrowStatus='down';
        HistoryPushState('sort_type', sort);
        HistoryPushState('sort_lay', arrowStatus);
    })
    $(document).on('click','.date-publish',function () {
        $('.select2-container .select2-dropdown').addClass('mtop');
    });
}
function getURLParameter(name) {
    var url = window.location.search.substring(1);
    var params = url.split('&');

    for (var i = 0; i < params.length; i++) {
        var param = params[i].split('=');

        if (param[0] === name) {
            return param[1] === undefined ? true : decodeURIComponent(param[1]);
        }
    }
}
function HistoryPushState(param, value){
    const url = new URL(window.location);

    url.searchParams.set(`${param}`, value);
    history.pushState(null, null, url);
    location.reload()
}
function changeUrlOnScroll(){
    let flag = 0;
    function elem_in_visible_area(selector) {
        let elem_p = selector,
            elem_p_height = elem_p.height(),
            offset_top_el = elem_p.offset().top,
            offset_bottom_el = offset_top_el + elem_p.height(),
            scrolled = $(window).scrollTop(),
            scrolled_bottom = scrolled + $(window).height();
        if (scrolled_bottom > offset_top_el && offset_bottom_el > scrolled) {
            return true;
        }
        return false;
    }

    $(window).scroll(function() {
        if($('.count').length > 0){
            if (elem_in_visible_area($('.count')) && flag === 0){
                CounterNumber();
                flag = 1;
            }
        }
    })
}
function CounterNumber(){
    $('.count > p').each(function () {
        $(this).prop('Counter',0).animate({
            Counter: $(this).text()
        }, {
            duration: 4000,
            easing: 'swing',
            step: function (now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
}
function AnimatedText(){
    let slag = $('.word').text();
    let slags = [slag,];
    var words = slags,
        part,
        i = 0,
        offset = 0,
        len = words.length,
        forwards = true,
        skip_count = 0,
        skip_delay = 15,
        speed = 500;

    var wordflick = function () {
        setInterval(function () {
            if (forwards) {
                if (offset >= words[i].length) {
                    ++skip_count;
                    if (skip_count == skip_delay) {
                        forwards = false;
                        skip_count = 0;
                    }
                }
            }
            else {
                if (offset == 0) {
                    $('.word').removeClass('bg-change-animate')
                    forwards = true;
                    i++;
                    offset = 0;
                    if (i >= len) {
                        i = 0;
                    }
                }
            }
            part = words[i].substr(0, offset);
            if (skip_count == 0) {
                if (forwards) {
                    offset++;
                }
                else {
                    // setTimeout()
                    $('.word').addClass('bg-change-animate')

                    offset=0;
                }
            }
            $('.word').text(part);
        },speed);
    };
    wordflick();
}
function initSlider1 (slider) {
    const swipers = $(`.${slider}`);
    console.log(swipers, 32332)
    swipers.each(function () {
        const ths = $(this);
        const id = ths.attr('id');
        console.log(id)
        new Swiper(`.${id}`, {
            slidesPerView: 1.2,
            watchOverflow: true,
            spaceBetween: 12,
            speed: 300,
            slidesPerGroup: 1,
            loop:true,
            pagination: {
                el: `.${id}__swiper-pagination`,
            },
        });

    });
}
function initSliderHistory () {
    if($('#slider-history .slider-history__slide').length <= 1){
        $('.swiper-button-prev-main-mobile').remove();
        $('.swiper-button-next-main-mobile').remove();
    }
    new Swiper('#slider-history', {
            slidesPerView: 1,
            watchOverflow: true,
            spaceBetween: 20,
            speed: 300,
            slidesPerGroup: 1,
            loop:true,
            pagination: {
                el: `.slider-history__swiper-pagination`,
            },
        navigation: {
            nextEl: ".swiper-button-prev-main-mobile",
            prevEl: ".swiper-button-next-main-mobile",
        },
    });
    new Swiper('#slider-history2', {
        slidesPerView: 1,
        watchOverflow: true,
        spaceBetween: 20,
        speed: 300,
        loop:true,
        slidesPerGroup: 1,
        pagination: {
            el: `.slider-history__swiper-pagination`,
        },
        navigation: {
            nextEl: ".swiper-button-prev-main-mobile",
            prevEl: ".swiper-button-next-main-mobile",
        },
    });
}


function initGallery() {
    if($('.base-damages-gallery .swiper-slide').length <= 1){
        $('.swiper-button-next-gallery').remove();
        $('.swiper-button-prev-gallery').remove();
        $('.swiper-button-next-damages1').remove();
        $('.swiper-button-prev-damages1').remove();
    }

    const gallery = $('.base-damages-one-post__img')

    gallery.each(function (){
        let ths= $(this)
        const sliderMain = ths.find('.base-damages-gallery').attr("id")
        const sliderThumbs = ths.find('.base-damages-slider').attr("id")
        const nextMain = ths.find('.swiper-button-next-gallery').attr("id")
        const prevMain = ths.find('.swiper-button-prev-gallery').attr("id")
        const nextThumbs = ths.find('.swiper-button-next-damages1').attr("id")
        const prevThumbs = ths.find('.swiper-button-prev-damages1').attr("id")
        // console.log('sliderMain', sliderMain)
        // console.log('sliderThumbs', sliderThumbs)

        let swiper = new Swiper(`#${sliderMain}`, {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesProgress: true,
            navigation: {
                nextEl: `#${nextMain}`,
                prevEl: `#${prevMain}`,
            },
        });
        let swiper2 = new Swiper(`#${sliderThumbs}`, {
            spaceBetween: 10,

            navigation: {
                nextEl: `#${nextThumbs}`,
                prevEl: `#${prevThumbs}`,
            },
            thumbs: {
                swiper: swiper,
            },
        });

    })
    var swiper = new Swiper(".article__img .base-damages-gallery", {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        navigation: {
            nextEl: ".article__img .swiper-button-next-gallery",
            prevEl: ".article__img .swiper-button-prev-gallery",
        },
    });


    var swiper2 = new Swiper(".article__img .base-damages-slider", {
        spaceBetween: 10,

        navigation: {
            nextEl: ".article__img .swiper-button-next-damages1",
            prevEl: ".article__img .swiper-button-prev-damages1",
        },
        thumbs: {
            swiper: swiper,
        },
    });
    $(".base-damages-gallery").closest('.swiper').find('.swiper-button-prev-gallery').hide();
    $(".base-damages-gallery").closest('.swiper').find('.swiper-button-next-gallery').hide();
    $(".base-damages-gallery").hover(
        function(){
            $(this).closest('.swiper').find('.swiper-button-prev-gallery').show();
            $(this).closest('.swiper').find('.swiper-button-next-gallery').show();
        },
        function(){
            $(this).closest('.swiper').find('.swiper-button-prev-gallery').hide();
            $(this).closest('.swiper').find('.swiper-button-next-gallery').hide();
        });
}


function Select2(){
    $('.select2-base-damages').select2({
        tags: true,
        language: {
            inputTooShort: function(args) {
                return "Введіть мінімум 2 символи для початку пошуку";
            },
            noResults: function() {
                return "Нічого не знайдено";
            },
            searching: function() {
                return "Пошук...";
            },
        }
    });

    $('.select2-main').select2({
        // tags: true,
        ajax: {
            url: ApiConst + 'search_settlements',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: (params) => {
                return {search: params.term}

            },
            processResults: function (data) {
                let addresses = data.data.settlements;
                let resultAdresses = addresses.map(item => ({
                    id: item.ID,
                    text:item.Name,
                }));
                return {
                    results: resultAdresses,
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        language: {
            inputTooShort: function(args) {
                return "Введіть мінімум 2 символи для початку пошуку";
            },
            noResults: function() {
                return "Нічого не знайдено";
            },
            searching: function() {
                return "Пошук...";
            },
        }
    });
    $('.select2-main').on('select2:select', function (e) {
        let valSetts = $(this).val();
        $(this).closest('.base-build-damages-find__wrapper').find('.select2.select2-container .select2-selection').css('background-color','#E2F3EF')
        $(this).closest('.base-build-damages-find__wrapper').find('.select2.select2-container .select2-selection').css('border','1px solid #465558')

        ajaxPostSettlement({settlement_id: valSetts})
    });

    $('.select-street').select2({
        // tags: true,
        ajax: {
            url: 'https://api.novaposhta.ua/v2.0/json/',
            dataType: 'json',
            type: 'post',
            delay: 250,
            data: (params) => {
                let valRef = $('select[name=settlement]').val();
                let ref = $('select[name=settlement]').find(`option[value=${valRef}]`).data('ref');
                return JSON.stringify({
                    "apiKey": "e2327fc34a55e83119870231c23dd6d6",
                    "modelName": "Address",
                    "calledMethod": "searchSettlementStreets",
                    "methodProperties": {
                        "StreetName": params.term,
                        "SettlementRef": ref,
                    }
                })
            },
            processResults: function (data) {
                let addresses = data.data[0].Addresses;
                let resultAdresses = addresses.map(item => ({
                    id: item.SettlementStreetDescription,
                    text:item.SettlementStreetDescription,
                }));

                return {
                    results: resultAdresses,
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        language: {
            inputTooShort: function(args) {
                return "Введіть мінімум 2 символи для початку пошуку";
            },
            noResults: function() {
                return "Нічого не знайдено";
            },
            searching: function() {
                return "Пошук...";
            },
        }
    });
    $('.select2-base-damages').on('select2:open', function() {
        $('.select2-search__field')[0].focus();
    });

    $('.select2-base-damages').on('select2:open',function (){
        if(window.location.pathname === '/wp-admin/post.php' || window.location.pathname === '/wp-admin/post-new.php' ){
            $('.select2-container .select2-dropdown').addClass('wpAdmin')
        }
    })

    $('.select2-data-publich').select2({
        minimumResultsForSearch: Infinity,
        tags: true,
    });
    $('.select2-data-publich').on('select2:select', function (e) {
       $(this).closest('.date-publish').find('.select2.select2-container .select2-selection').addClass('border-click')
    });

    $(document).on('change','.select2-base-damages',function (){
        $(this).closest('.base-select').find('.select2-container--default .select2-selection--single').css('background-color','#E2F3EF')
        $(this).closest('.base-select').find('.select2-container--default .select2-selection--single').css('border','1px solid #465558')
        $(this).closest('.base-build-damages-find__wrapper').find('.select2-container--default .select2-selection--single').css('background-color','#E2F3EF')
        $(this).closest('.base-build-damages-find__wrapper').find('.select2-container--default .select2-selection--single').css('border','1px solid #465558')
    })

    $(document).on('click','.button-clear-all',function (){
        $('.select2-base-damages').val('').trigger('change');
        $('#datepicker1').val('');
        $('#datepicker2').val('');
        $('.base-select').find('.select2-container--default .select2-selection--single').css('background-color','#fff')
        $('.base-select').find('.select2-container--default .select2-selection--single').css('border','1px solid #DEE3E7')
        $('#datepicker2').css('background','#fff')
        $('#datepicker2').css('border','1px solid #DEE3E7')
        $('#datepicker1').css('background','#fff')
        $('#datepicker1').css('border','1px solid #DEE3E7')
    })
    $(document).on('click','.button-base-dameges',function () {
       $('.filter-big').addClass('filter-active')

    })

};

function findObjectsBaseDamage(){
    $('.count-posts > h5').text('0');
    $('.count-posts').addClass('not-find');
    // $('.date-publish').addClass('date-publish-disable');
}
function searchMain() {
    $('.close-button-search').hide();

    $(document).on('click','#search-main',function () {
        $('.header-social').hide();
        $('.close-button-search').show();
        $('.header-search').addClass('width-search')
    })
    $(document).on('click','.close-button-search',function () {
        $('#search-main').val('');
        $('.close-button-search').hide();
    })
    if ($(window).width() > 666) {
        $('#search-main').focusout(function () {
            $('.header-social').show();
            $('.header-search').removeClass('width-search')
        })
    } else {
        $(document).on('click','.header-mobile-search',function () {
            $('.header__burger-mobile').hide();
            $('.header-logo').hide();
            $('.header-profile').hide();
            $('.header-search').css('display', 'flex');
            $('.header__wrapper-search').css('width','100%');
        })
        $('#search-main').focusout(function () {
            $('.header__burger-mobile').show();
            $('.header-logo').show();
            $('.header-profile').show();
            $('.header-search').css('display', 'none');
            $('.header__wrapper-search').css('width','unset');
        })
    }
    $("#search-main").bind("keypress", {}, keypressInSearch);
    $(document).on('click','.button-search-main',function (e) {
        let val = $("#search-main2").val();
        let dataUrl = $(".header-search").data('url-search');
            e.preventDefault();
            window.location = dataUrl + '?search=' + val;

    })
    $(document).on('click','.button-search',function (e) {
        let val = $("input[type=radio]:checked").val();
            e.preventDefault();
            let url = $(this).closest('.filter-form').data('url-author');
            window.location = url + '/?filter=' + val;
            // HistoryPushState('filter',val)
    })
    $(document).on('click','.author-category__one',function (e) {
        let url = $(this).closest('.author-category').data('url-author');
        let val = $(this).data('name');
        window.location = url + '/?filter=' + val;
        // HistoryPushState('filter',val)
    })

}

function keypressInSearch(e) {
    var code = (e.keyCode ? e.keyCode : e.which);
    let val = $("#search-main").val();
    let dataUrl = $(".header-search").data('url-search');
    if (code == 13 && val!=='') {
        e.preventDefault();
        window.location = dataUrl + '?search=' + val;
    }
};

function dropMenu() {
        $('.header-dropdown').click(function() {
            $('.header-dropdown-list').show();
            $(this).addClass('header-dropdown-open')
        });
        $(document).click(function(event) {
            var target = $(event.target);

            if (target[0]!==$('.header-dropdown')[0] && target[0]!==$('.header-dropdown > h3')[0] && target[0]!==$('.header-dropdown > svg')[0]) {
                $('.header-dropdown-list').hide();
                $('.header-dropdown').removeClass('header-dropdown-open')
            }
        });
    $(document).click(function(event) {
        var target = $(event.target);

        if(target[0]==$('.header-menu-mobile.open')[0] && target[0]!==$('.header-burger > img')[0]){
            $('.header-menu-mobile').removeClass('open');
            $('body').removeClass('hidden-scroll');
        }
    })
}

function burgerMenu() {
    $(document).on('click','.header-burger',function () {
        $('.header-menu-mobile').addClass('open')
        $('body').addClass('hidden-scroll')
    })
    $(document).on('click','.close-mobile-burger',function () {
        $('.header-menu-mobile').removeClass('open')
        $('body').removeClass('hidden-scroll')
    })

}

function SliderMain() {
    var $swiper = $(".swiper-container");
    var $bottomSlide = null;
    var $bottomSlideContent = null;
    var mySwiper = new Swiper(".swiper-container", {
        spaceBetween: 1,
        slidesPerView: 5,
        centeredSlides: true,
        speed: 600,
        roundLengths: true,
        loop: true,
        allowTouchMove:false,
        loopAdditionalSlides: 30,
        pagination: {
            el: ".swiper-pagination",
        },
        navigation: {
            nextEl: ".swiper-button-next-main",
            prevEl: ".swiper-button-prev-main"
        },
        on: {
            slideChange: function () {
                var totalSlides = this.slides.length / 3;
                var activeIndex = (this.activeIndex % totalSlides) +1;
                $('.swiper-counter > h2').text('0' + activeIndex);
                $('.swiper-counter > h4').text('/ 0' + totalSlides);
                },
        },
    });
    if(window.innerWidth <= 666){
        var swip = new Swiper(".main-mobile-slider", {
            spaceBetween: 10,
            slidesPerView: 1,
            navigation: {
                nextEl: ".swiper-button-prev-main-mobile",
                prevEl: ".swiper-button-next-main-mobile",
            },
        });
    }

}
function MobileVersion(){
    if(window.innerWidth < 666){
        initSlider1('slider-history');
    }
    else{
        $(document).on('click','.date-publish',function () {
            $('.select2-results').addClass('filter-font');
        });
    }
    if($('.history').length > 0){
        $('#ui-datepicker-div').addClass('history-Picker')
    }
    if($('.base-damages').length > 0){
        $('#ui-datepicker-div').addClass('base-damages-Picker')
    }
}
let currentPage;
let searchTimeout;
function SendForm(){
    $(document).on('submit','#base-dameges',function (e) {
        setCookie('removePage','true')
        $('.select2-base-damages').each(function () {
            if ($(this)[0].value === "")$(this).attr('disabled',true)
        })
        if($('#select-street').val()==='')$('#select-street').attr('disabled',true)
        if($('#select-number-home').val()==='')$('#select-number-home').attr('disabled',true)
        if($('input[name=start_date]').val()==='')$('input[name=start_date]').attr('disabled',true)
        if($('input[name=end_date]').val()==='')$('input[name=end_date]').attr('disabled',true)
        let form = $('#base-dameges');
        let data = form.serialize();
        ajaxFindObjects(data);
    })



}
function getURLParameter(name) {
    var url = window.location.search.substring(1);
    var params = url.split('&');

    for (var i = 0; i < params.length; i++) {
        var param = params[i].split('=');

        if (param[0] === name) {
            return param[1] === undefined ? true : decodeURIComponent(param[1]);
        }
    }
}
function SendGlobalFilter(){
    $(document).on('click','.main-search-filter__one', function (){
        $('.main-search-filter__one').removeClass('active');
        $(this).addClass('active');
        let filter = $(this).data('name');
        let search = getURLParameter('search');
        if(filter === undefined)filter='';
        let url =  window.location.origin + '/search_page' + '/?search=' + search + '&filter=' + filter
        window.location = url;
    })
    $(document).on('click','.button-search1',function (e) {
        let val = $("input[type=radio]:checked").val();
        e.preventDefault();
        let search = getURLParameter('search');
        // let url = $(this).closest('.filter-form').data('url-author');
        let url =  window.location.origin + '/search_page' + '/?search=' + search + '&filter=' + val
        window.location = url;
        // window.location = url + '/?filter=' + val;
        // HistoryPushState('filter',val)
    })
}
// let search;
// function onChangeSearch () {
//     clearTimeout(searchTimeout);
//     searchTimeout = setTimeout(function () {
//         search = $('#search-main').val();
//         let obj = {search};
//         ajaxGlobalSearch(obj);
//     }, 3000);
// }
function setCookie(cname, cvalue) {
    document.cookie = cname + "=" + cvalue;
}
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function goBack(){
    $('.error__button').click(function () {
        console.log('window.history.length', window.history.length)
        if( window.history.length == 1){
            window.location.href = '/'
        }
        history.back()
    })

}


function CopyLinkFunc(){
    $(document).on('click','.copy_link', function (e){
        // e.preventDefault();
        let copyText = window.location.href;
        navigator.clipboard.writeText(copyText);
        console.log('copyText', copyText)
    })
};
//# sourceMappingURL=app.js.map