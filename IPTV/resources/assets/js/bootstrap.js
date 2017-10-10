
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
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjM2NzNlOThmYWFmYzc5OTQ0NjBiNDAyMjMzMDY0OTdhNDYyZTMxZTg3ZjAyODg0M2Y5MTdjOGIzY2RhM2Q4MDJkNzhmOTI3YzJhYmVkYmEzIn0.eyJhdWQiOiIzIiwianRpIjoiMzY3M2U5OGZhYWZjNzk5NDQ2MGI0MDIyMzMwNjQ5N2E0NjJlMzFlODdmMDI4ODQzZjkxN2M4YjNjZGEzZDgwMmQ3OGY5MjdjMmFiZWRiYTMiLCJpYXQiOjE1MDc2Mzk2NTEsIm5iZiI6MTUwNzYzOTY1MSwiZXhwIjoxNTEwMzE4MDUxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.k7IQaBsEvsHfsvEzYXPO6-dUZTN8bHK0HUdwnLxOqPqPEjIVakqwLG0dnBwqt8-I_Opl_F90FyVtYtqe2uOpNYlepOzbis1zYQW579GmxDDknANgl-uDUN950Lq_FfR0SSGkqhQGH-Lw7yELG-7GCHmLB574h_LUMDzpFAYzbqMHtO0izO7D_8t4rzITKWFC_Iyh-g1OgLJsmGcjVRrSza54QeHiop5Ri3UyU40S1NcGa8x6lW4u4X8USvki6_Vz4w5sgsfx-4P4xsRGV_qPIjsJhex2rbN-NmXw0kMoLSfQ5-dfruuM7Jz6lfRp8ieD8Mca2y5i73MaPLYze0vN76pCFKEoL4gxKBdtz0RVChfMylKnrbqjRxXNI1FoQxjsR3WkuM7EmqR8qujLwm6YIs73ufhqRZkCKlxpNvabicBTCk-LW2VcyqjfZ5v56I_x42ErLnReW6Mf-pwa5rxt28Bw4Gd1vRsvVQmsh70fH4m31r6TM84EpUyCwliDtacf0u80bQ-xk3pYTi57mNX7JJdi5GrtNPuMItAniiRT16YFfDv2fCId4WtwW5ZuFCbq0vu_OI6bNSK87U1_PzG52ZtVAteV6Uyi9BP-pyHKq68ociCQR55LvDJMdnXm4Eq7uS4kO3vpCaRD3MKjj3WFkjkeZoZeSFea1uYDmUPVOek',
        },
    },
});
