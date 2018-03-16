
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
            Authorization: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjI0MjQ5YTM3NTQxMDBjZGM2ZTU4N2VhMGQ3ZmJkZDgzYmVhNjc3N2E0NjhkOTQzOGM5MDAwNWI4YjM4NjAxZGFmM2VkY2Y1OGE1ZmU5MzA3In0.eyJhdWQiOiIxIiwianRpIjoiMjQyNDlhMzc1NDEwMGNkYzZlNTg3ZWEwZDdmYmRkODNiZWE2Nzc3YTQ2OGQ5NDM4YzkwMDA1YjhiMzg2MDFkYWYzZWRjZjU4YTVmZTkzMDciLCJpYXQiOjE1MjExOTQwODYsIm5iZiI6MTUyMTE5NDA4NiwiZXhwIjoxNTIzODcyNDg2LCJzdWIiOiIxIiwic2NvcGVzIjpbIioiXX0.ZwOc070Haq4nFetJ2jsYlE_oPut8ZhXCXEH3mD3b91qXGvKGPm1dbDDwCzjdh4Xr7MCbcA62RL7zvDyltQDOj3KNby0Ccx4Quvehwx15ik4nRlwOmyu9WX0ZblEhbYCv7OE73pAUt6ijGtQrcm93RL8DGNpxV4rjEg6UuVJ7pud82QYPNEI5zVSk7qbxro08K1Ct9tFG_ZC7RnLI-A7SpbRXZY7WMQC6ESRJ1_9dbb21vPxMDqvCvfvm4FaN0z9ZUsukZymzaSq1d0OGQHHKz8iwDlLeHPa9o3bplAQtfQIeTEGrBj0F1ixqjDy3-KUtlucQfpkN4zHe9efNKlkO4qQdCs8w_u53lamd0ur7IovCInZJMgs4LuFeLOL23C8nh3C5viEW_Xhbpldx8raIr5gC_8xieQ7gj8YgilGTJTLwDiPU88hr9zB6F_5AwTwBZFjBUCypWmr-dEn9OmQNhS866xKld_bwVdXbLp7NTIhh0VmYabsmQrfqYOFCykMcPf9Bt1K_ZS7Uj7LhwpUn5Lh-VS42IZWKuwdWzDBOV0C-efAnT4prIn_r3L-25OrC4yCKM0HmggsbX5bn2sNccLo7XPSDdCksBZeqZAE7_8XlaTdJzvPbbRCVzVDQrFDcY_vf38_mk5ZWglSGKUjuagRe-VuYghPqLO71lFFncYo',
        },
    },
});
