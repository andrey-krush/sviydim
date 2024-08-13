
console.log('apiServer34');
let ApiConst = window.location.origin + '/wp-admin/admin-ajax.php?action=';
const API = {
    findObjects: ApiConst + 'filter',
    globalSearch: ApiConst + 'global_search',
    searchFilter: ApiConst + 'search_filter',
    getRegions: ApiConst + 'get_regions_by_area',
    getSettlement: ApiConst + 'get_settlements_by_region',
    postSettlement: ApiConst + 'generate_base_damage_url',
    postStreet: ApiConst + 'get_streets_by_settlement',
};

function ajaxFindObjects(date) {
    $.ajax({
        url: ApiConst,
        dataType: "json",
        data: date,
        method: 'GET',
        success: function (data) {
            console.log('data', data);
        },
        error: function (error) {
            console.log(error);
            findObjectsBaseDamage();
        },
        complete: function () {
        },
    });
}

// function ajaxGlobalSearch(date) {
//     $.ajax({
//         url: API.globalSearch,
//         dataType: "json",
//         data: date,
//         method: 'POST',
//         success: function (data) {
//             console.log('data', data);
//             $('section').remove();
//             data.html.insertAfter("header");
//         },
//         error: function (error) {
//
//             console.log(error);
//         },
//         complete: function () {
//         },
//     });
// }

function ajaxSearchFilter(date) {
    $.ajax({
        url: API.searchFilter,
        dataType: "json",
        data: date,
        method: 'POST',
        success: function (data) {
            console.log('data', data);
        },
        error: function (error) {

            console.log(error);
        },
        complete: function () {
        },
    });
}

function ajaxGetArea(date) {
    $.ajax({
        url: API.getRegions,
        dataType: "json",
        data: date,
        method: 'POST',
        success: function (data) {
            console.log('data', data);
            if(window.location.pathname === '/wp-admin/post.php' || window.location.pathname === '/wp-admin/post-new.php' ){
                fillSelectRay1(data.data.regions)
            }
            else{
                fillSelectRay(data.data.regions)
            }
            console.log(ajax1Returned, ajax2Returned, 'ajax1Returned')
            if(!ajax1Returned || !ajax2Returned || !ajax3Returned){
                ajax1Returned = true;
                changeFilterAfterReload()
            }

        },
        error: function (error) {

            console.log(error);
        },
    });
}

function ajaxGetSettlement(date) {
    $.ajax({
        url: API.getSettlement,
        dataType: "json",
        data: date,
        method: 'POST',
        success: function (data) {
            console.log('data', data);
            if(window.location.pathname === '/wp-admin/post.php' || window.location.pathname === '/wp-admin/post-new.php' ){
                fillSelectSettl1(data.data.settlements)
            }
            else{
                fillSelectSettl(data.data.settlements)
            }

            if(!ajax1Returned || !ajax2Returned || !ajax3Returned){
                ajax2Returned = true;
                changeFilterAfterReload()
            }
        },
        error: function (error) {

            console.log(error);
        },
        complete: function () {
        },
    });
}

function ajaxGetStreet(date) {
    console.log(4433443)
    $.ajax({
        url: API.postStreet,
        dataType: "json",
        data: date,
        method: 'POST',
        success: function (data) {
            console.log('data232', data);
            fillSelectStreet(data.data.streets)
            console.log(45454554);
            if(!ajax1Returned || !ajax2Returned || !ajax3Returned){
                ajax3Returned = true;
                changeFilterAfterReload()
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
}
function ajaxPostSettlement(date) {
    $.ajax({
        url: API.postSettlement,
        dataType: "json",
        data: date,
        method: 'POST',
        success: function (data) {
            // console.log('data', data);
            $('.main-search-base a').attr('href',`${data.data.base_damage_link}`)
        },
        error: function (error) {
            console.log(error);
        },
        complete: function () {
        },
    });
}


/* ============================ apiServer END ================================================================= */
