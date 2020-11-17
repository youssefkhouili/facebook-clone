import Vue from "vue"
import router from "./router"
import App from "./App.vue"
import store from "./store"

require('./bootstrap');

window.Vue = require('vue');

Vue.filter('capitalize', (value) => {
    return value.toLowerCase().split(' ').map(word => word.charAt(0).toUpperCase() + word.substring(1)).join(' ')
})

const app = new Vue({
    el: '#app',
    components: {
        App
    },
    router,
    store
});
