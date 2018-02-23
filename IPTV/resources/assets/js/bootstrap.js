
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
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImY1NzI5MjA4YjM3MjFiYmNiNDBhNjc0N2U2ODU3Njg5NzZhZDQwODQ3MjkxNTI0MGQ3NDZiYTQwYmJkYzgyYjkyYzE1NGZiM2YzMjk5MGVjIn0.eyJhdWQiOiIxIiwianRpIjoiZjU3MjkyMDhiMzcyMWJiY2I0MGE2NzQ3ZTY4NTc2ODk3NmFkNDA4NDcyOTE1MjQwZDc0NmJhNDBiYmRjODJiOTJjMTU0ZmIzZjMyOTkwZWMiLCJpYXQiOjE1MTg3MDUzODAsIm5iZiI6MTUxODcwNTM4MCwiZXhwIjoxNTIxMTI0NTgwLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.la9VBz1Bg_u8RfcWznW__KIPFUULR169Y3xJvpOc-yuWwqvMxA70GqXxuhHNPyqEhOHYCuKwWC7HpDjQwp8IZt2jDRztfkPkdNTiGM9G2EDDmvBox8VYNzMDxqWzaWdR83AGroeDAmUasJsLpG7WnEm0sqPGPv-CxE8vERqP9mOn93EzpUcW3ehotty6W7S44mk2gUFNhHyV90jcwz38vQdlNE4WfNZqGAd_2b4v-oqBC89xlBCnH7f2Z-VuOyJDoRjB-zJusGwR-zdrAlfu0j10-e_6-XwThXrYGGwWvNIZOfIWL-G71R8vWZBr0Gy3QnqhybA5vLj-0hIiqZGwOhV-0AQSKzVph0dKTrBpAotD8Pn-8jZlzWfIk-nhpZqQkds21JLWbgjer8ebX9hABQQ5T0YAKtKe_pDR2lEGZM5uT30mbeCC2wWC-uIckXy4fEheVhhzgKXPda9pAGB6rhTaZhaLerZYnWxHuLNw3VjM1In-2sBqO4fqyNaNS7sggYQkXJ8OLgHpduDyRrWKWziYjeRxDIheZJdsJuvdSjRV-E-zj_mj60CfEWYhCXft7iICfcuhd-Yy2rnKKr5-Qdgs5dPrGN-FnMQr-CaDu0VW2H_7EI-P3qiLl7V6_vKqPYQupftRSqcl3k8N-aVl5f6ZGvKoL8Aeet7DN1aP110',
        },
    },
});
