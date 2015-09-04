/**
 * This script has two purposes
 * - Advanced search engine
 */
var Filter = function (name, category) {
    this.name = name;
};
//se crea Objeto para guardar datos
var advStorage = new Storage();
var advSearchSrcUrl = baseUrl + "controller/action"
var mainContainerClass = 'advs-container';//config
var filterTagClass = 'advs-filter';//config
var filterSelectedClass = 'advs-filter-selected';//config
var appliedFilters = [];//filtros aplicados

//load applied filters ON DOCUMENT READY!->
if (advStorage.getSiteWideValue("advs-applied-filters") !== undefined && JSON.parse(advStorage.getSiteWideValue("advs-applied-filters")).length > 0)
    appliedFilters = JSON.parse(advStorage.getSiteWideValue("advs-applied-filters")).length > 0;
//poner como seleccionado a los que se encuentran seleccionados
$(filterTagClass).each(function () {
    if (appliedFilters.length === 0)
        return;

    var name = $(this).attr('data-filter-name');
    if (name.length > 0 && $.inArray(name, appliedFilters)) {
        //esta dentro del array de filtros aplicados
        $(this).addClass(filterSelectedClass);
    }
    //mostrar
    $(mainContainerClass).show();

});
$(filterTagClass).click(function () {
    var name = $(this).attr('data-filter-name');
    if (!$(this).hasClass(filterSelectedClass)) {
        appliedFilters.push(name);
        advStorage.setSiteWideValue("advs-applied-filters", JSON.stringify(appliedFilters));
        $(this).addClass(filterSelectedClass);
        var getQuery = window.location.search.match(/(\?|&)query\=([^&]*)/);
        var query = decodeURIComponent((getQuery[2].length > 0) ? getQuery[2] : '');
        var getPage = window.location.search.match(/(\?|&)page\=([^&]*)/);
        var page = decodeURIComponent((getQuery[2].length > 0) ? getQuery[2] : '');
        var filters = '';
        appliedFilters.forEach(function (n) {
            filters += n+",";
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
    }
});
//<-ON DOCUMENT READY!


advStorage.setSiteWideValue("COOKIE1", "TASTY!!!");
console.log(advStorage.getSiteWideValue("COOKIE1"));


