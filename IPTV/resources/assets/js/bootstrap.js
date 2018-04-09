
window._ = require('lodash');

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap-sass');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo"

window.Echo = new Echo({
    broadcaster: 'socket.io',
    host: window.location.hostname + ':6001',
    auth:{
        headers: {
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjFiODcxMGY3MWJiYzczZWUyMWQ1NjdlZTlmODljNGY2MmNjZTZjYzE1NjFkZjExZjIxYmViNjg3MWViZjAwZjI0MjJlZmEyYTRiZmU5YzdmIn0.eyJhdWQiOiIxIiwianRpIjoiMWI4NzEwZjcxYmJjNzNlZTIxZDU2N2VlOWY4OWM0ZjYyY2NlNmNjMTU2MWRmMTFmMjFiZWI2ODcxZWJmMDBmMjQyMmVmYTJhNGJmZTljN2YiLCJpYXQiOjE1MjIwNDc0NTQsIm5iZiI6MTUyMjA0NzQ1NCwiZXhwIjoxNTI0NzI1ODU0LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.qEsU-naW6ZxddGxuX3xwrPfCOz_8B79S46IXGIhmMLT8ILpSHf0shl76yBjiTKuqh7zXk36U4ZJPnDWZOb2M4zfEMPaKmmXMy2krYcEZtJNxtAMeFf24r6I9NtOpivv7GuDLT58YVW-nDHlJFsOLYB_FMdO8IbQRT6_porD1rmpQWaxUeP7fkrZlaEIEOXwunhZpkTfNRwPmypkcVKEy3Zt1WCKhqiS1nh14X8b0VHkC5tmwGh9Dp2fist9dEhanUpn9_0ao8VmsHebgHX3DcmudjfqPiDGphKF6Rd-yilTVRiU9_RyPFx_sl-5FxBOLbrsJysLqOljRpqyx-6N9B-oQuybFbleVfr-acarKoNLZvq0AFm-i2v5yM_fjvaqa3s2lgH_NVtOgyIzkonLvybp1l-JkCVoc08_kP0v6Mo6kHT5AzrVlUHPvJZ2L3gweIVvK9XDxj4MTWQwlTGa5-sQqzlrBhDHERpA-9pX3siU0qFiCaOF9xnr0QxyIh3nhfNkPLz81CL9AeAER5OgVrqpcidyMyTaSVlPrRU_Hm0X_hyWngDdL9dZ8SiV8N-G6LFB46Xx1_6oqWJQzG3S4RcP8hj69jcsNKPdc6I25tnOKCY0_-JMLsKK0ElmSczkt9EC6jqfZg3eY6Cx4wC1kZzNI8-UCQG8m_1Lluq-Vrz4',
        },
    },
});
