export const UTILS = {
    foodVariants: {
        breakfast: 'Завтраки',
        full: 'Полный пансион',
        no_food: 'Без питания',
        custom: 'Индивидуальный подбор питания'
    },
    configToString: function (config) {
        let arr = []
        for (let nextClassName in config) {
            if (config.hasOwnProperty(nextClassName) && config[nextClassName]) {
                arr.push(nextClassName)
            }
        }
        return arr.join(' ')
    },
    normalizeBoolean: function (value) {
        let re = new RegExp('^true$', 'i')
        return re.test(value)
    },
    normalizeInteger: function (value) {
        let length = parseInt(value, 10)
        let isInteger = Number.isInteger(length)
        return isInteger ? length : null
    },
    normalizeString: function (value, config) {
        let normalized = (typeof value === 'string' && value.trim()) || ''
        normalized = normalized.toLowerCase()
        if (config.validValues && !config.validValues.includes(normalized)) {
            normalized = config.fallbackValue
        }
        return normalized
    }
}


export function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}


// Пример использования:
// setCookie('user', 'John', {secure: true, 'max-age': 3600});
export function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };

    if (options.expires && options.expires.toUTCString) {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

    for (let optionKey in options) {
        updatedCookie += "; " + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }

    document.cookie = updatedCookie;
}