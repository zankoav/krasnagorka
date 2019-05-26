export const Validator = {
    ERROR_EMPTY_FIELD: 'Поле обязательно для заполнения',
    ERROR_EMAIL_FIELD: 'Введите корректный email',
    ERROR_AGREE_FIELD: 'Необходимо согласие на обработку данных',
    ERROR_PHONE_FORMAT_FIELD: 'Не верный формат телефона: +375YYXXXXXXX',
    email: function (email) {
        let re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
    },
    phone: function (phone) {
        let re = /^\+375 (17|25|29|33|44) [0-9]{3} [0-9]{2} [0-9]{2}$/;
        return re.test(phone);
    },
    phoneType2: function (phone) {
        let re = /^\+375(17|25|29|33|44)[0-9]{7}$/;
        return re.test(phone);
    }
};