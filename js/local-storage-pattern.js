/* 
 * * - Deals with persisting data in LocalStorage/Cookie -
 * * - Nicommit -
 */

//cookie saving (could be inside another file)
function setCookie(key, val, exdays) {
    exdays = typeof exdays !== 'undefined' ? exdays : 1;//default value
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = key + "=" + val + "; " + expires;
}
//storage object
var Storage = function(){
    this._hasStorage = function () {
        try {
            localStorage.setItem(mod, mod);
            localStorage.removeItem(mod);
            return true;
        } catch (e) {
            return false;
        }
    };
    this.getSiteWideValue = function (_key) {
        if (this._hasStorage()) {
            return localStorage[_key];
        }
        else {
            if (document.cookie.indexOf(_key + '=') !== -1) {
                return document.cookie.split(_key + '=')[1].split(';')[0];
            }
        }
    };
    this.setSiteWideValue = function (_key, _value) {
        if (this._hasStorage()) {
            localStorage[_key] = _value;
        }
        else {
            setCookie(_key, _value);
        }
    };

};
/*//
 //Local Storage Pattern (could be inside another file)
 // credits to http://mathiasbynens.be/notes/localstorage-pattern
 var hasStorage = (function () {
 try {
 localStorage.setItem(mod, mod);
 localStorage.removeItem(mod);
 return true;
 } catch (e) {
 return false;
 }
 }());
 
 function setSiteWideValue(_key, _value) {
 if (hasStorage) {
 localStorage[_key] = _value;
 }
 else {
 setCookie(_key, _value);
 }
 }
 
 function getSiteWideValue(_key) {
 if (hasStorage) {
 return localStorage[_key];
 }
 else {
 if (document.cookie.indexOf(_key + '=') != -1) {
 return document.cookie.split(_key + '=')[1].split(';')[0];
 }
 }
 }
 //*/

