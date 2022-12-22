export const UTILS = {
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
