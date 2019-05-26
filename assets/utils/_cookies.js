window.setCookie = function (key, value){
    let date = new Date(new Date().getTime() + 365 * 24 * 3600 * 1000);
    document.cookie = `${key}=${value}; path=/; expires=` + date.toUTCString();
};

window.getCookie = function(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
};