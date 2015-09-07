/**
 * This script has two purposes
 * - Advanced search engine
 */

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};
var Filter = function (name, category) {
    this.name = name;
};
//se crea Objeto para guardar datos
var advStorage = new Storage();
var advSearchSrcUrl = baseUrl + "advancedsearch"
var mainContainerClass = '.advs-container';//config
var filterTagClass = '.advs-filter';//config
var filterSelectedClass = 'advs-filter-selected';//config
var appliedFilters = [];//filtros aplicados
$(document).ready(function () {
    var query = getUrlParameter('query');
    if (query !== undefined) {//maybe show error
        setQueryParam(query);
    }
//load applied filters ON DOCUMENT READY!->
    if (advStorage.getSiteWideValue("advs-applied-filters") !== undefined && JSON.parse(advStorage.getSiteWideValue("advs-applied-filters")).length > 0)
        appliedFilters = JSON.parse(advStorage.getSiteWideValue("advs-applied-filters"));
//poner como seleccionado a los que se encuentran seleccionados
    $(filterTagClass).each(function () {
        if (appliedFilters.length === 0)
            return;

        var name = $(this).attr('data-filter-name');
        if (name.length > 0 && $.inArray(name, appliedFilters) > -1) {
            //esta dentro del array de filtros aplicados
            $(this).addClass(filterSelectedClass);
        }
        //mostrar
        $(mainContainerClass).show();

    });
    function getQueryParam() {
        return $("#advs-query").val();
    }
    function setQueryParam(value) {
        $("#advs-query").val(value);
    }
    $(filterTagClass).click(function () {

        var query = getQueryParam();
        if (query === undefined) {//maybe show error
            alert("No hay nada que buscar");
            return;
        }
        var name = $(this).attr('data-filter-name');
        if (!$(this).hasClass(filterSelectedClass)) {

            appliedFilters.push(name);
            advStorage.setSiteWideValue("advs-applied-filters", JSON.stringify(appliedFilters));
            $(this).addClass(filterSelectedClass);

            var page = getUrlParameter('page');
            if (page === undefined)
                page = '1';
            filters = '';
            appliedFilters.forEach(function (n) {
                console.log(n);
                filters += n + ",";
            });
            window.location.href = advSearchSrcUrl + '?query=' + query + '&filters=' + filters + '&page=' + page;
            return;
        } else {
            //diselection
            $(this).removeClass(filterSelectedClass);
            //sacar del array appliedFilters
            appliedFilters.forEach(function (n, index) {
                if (name === n) {
                    appliedFilters.splice(index, 1);
                    return;//break?
                }
            });

            advStorage.setSiteWideValue("advs-applied-filters", JSON.stringify(appliedFilters));
            var page = getUrlParameter('page');
            if (page === undefined)
                page = '1';
            filters = '';
            appliedFilters.forEach(function (n) {
                console.log(n);
                filters += n + ",";
            });
            window.location.href = advSearchSrcUrl + '?query=' + query + '&filters=' + filters + '&page=' + page;
            return;
        }
    });
//<-ON DOCUMENT READY!
});

advStorage.setSiteWideValue("COOKIE1", "TASTY!!!");
console.log(advStorage.getSiteWideValue("COOKIE1"));


