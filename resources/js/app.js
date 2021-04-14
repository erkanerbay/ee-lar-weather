/**
 * app.js
 */
import Vue from 'vue';
import Multiselect from 'vue-multiselect'
import axios from "axios";
import VueAxios from "vue-axios";

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.baseURL = config.api;
axios.interceptors.request.use(
    function(config) {
        console.log("Axios request config", config);
        return new Promise(resolve => setTimeout(() => resolve(config), 400));
    },
    function(error) {
        console.log("Axios request error", error);
        return Promise.reject(error);
    }
);

axios.interceptors.response.use(
    function(response) {
        console.log("Axios response", response);
        return response;
    },
    function(error) {
        console.log("Axios response error", error);
        return Promise.reject(error);
    }
);

Vue.use(VueAxios, axios);

// const Multiselect = require('vue-multiselect');
Vue.component('multiselect', Multiselect);

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

new Vue({el: '#app'});
